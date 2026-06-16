<?php
namespace App\Services;

use App\Models\Signal;
use Illuminate\Support\Facades\Log;

class AutoSignalService
{
    public function __construct(
        private MarketDataService       $marketData,
        private PipCalculatorService    $pips,
        private MessageFormatterService $formatter,
        private TelegramService     $telegram
    ) {}

    /**
     * Decide whether to fire this run based on configured chance,
     * then build + submit a signal using a REAL current price.
     */
    public function maybeGenerate(): ?Signal
    {
        $chance = config('services.auto_signal.fire_chance');
        $roll   = rand(1, 100);

        Log::channel('telegram')->info('🎲 AUTO-SIGNAL ROLL', ['roll' => $roll, 'threshold' => $chance]);

        if ($roll > $chance) {
            Log::channel('telegram')->info('⏭️ AUTO-SIGNAL SKIPPED THIS HOUR');
            return null;
        }

        $pairs = config('services.auto_signal.pairs');
        $pair  = $pairs[array_rand($pairs)];

        $price = $this->marketData->getPrice($pair);

        if (!$price) {
            Log::channel('telegram')->error('❌ AUTO-SIGNAL ABORTED — no price', ['pair' => $pair]);
            return null;
        }

        return $this->buildSignal($pair, $price);
    }

    private function buildSignal(string $pair, float $price): Signal
    {
        $direction = rand(0, 1) ? 'BUY' : 'SELL';
        $rr        = config('services.auto_signal.risk_reward');

        // SL distance: a modest % of price, scaled by instrument type
        $multiplier = $this->slDistanceMultiplier($pair);
        $slDistance = $price * $multiplier;

        $digits = $this->decimalsFor($pair);

        if ($direction === 'BUY') {
            $entryMin = round($price, $digits);
            $entryMax = round($price + ($slDistance * 0.3), $digits);
            $sl       = round($price - $slDistance, $digits);
            $tp1      = round($price + ($slDistance * $rr * 0.5), $digits);
            $tp2      = round($price + ($slDistance * $rr), $digits);
            $tp3      = round($price + ($slDistance * $rr * 1.5), $digits);
        } else {
            $entryMin = round($price - ($slDistance * 0.3), $digits);
            $entryMax = round($price, $digits);
            $sl       = round($price + $slDistance, $digits);
            $tp1      = round($price - ($slDistance * $rr * 0.5), $digits);
            $tp2      = round($price - ($slDistance * $rr), $digits);
            $tp3      = round($price - ($slDistance * $rr * 1.5), $digits);
        }

        $signal = Signal::create([
            'pair'      => $pair,
            'direction' => $direction,
            'entry_min' => $entryMin,
            'entry_max' => $entryMax,
            'sl'        => $sl,
            'tp1'       => $tp1,
            'tp2'       => $tp2,
            'tp3'       => $tp3,
            'channel'   => 'public',
            'status'    => 'draft',
        ]);

        $signal->update(['signal_text' => $this->formatter->formatSignal($signal)]);

        Log::channel('telegram')->info('🤖 AUTO-SIGNAL BUILT', $signal->toArray());

        // Submit straight to the approval desk — human still approves before it posts
        $signal->update(['status' => 'pending_approval']);
        $this->telegram->sendSignalPreview($signal);

        return $signal;
    }

    private function slDistanceMultiplier(string $pair): float
    {
        // Tighter for forex majors, wider for metals/indices/crypto
        return match (true) {
            str_contains($pair, 'JPY')                          => 0.004,
            str_contains($pair, 'XAU') || str_contains($pair, 'XAG') => 0.006,
            str_contains($pair, 'BTC') || str_contains($pair, 'ETH') => 0.015,
            str_contains($pair, 'NAS') || str_contains($pair, 'US30') => 0.006,
            default                                              => 0.003, // standard forex
        };
    }

    private function decimalsFor(string $pair): int
    {
        return match (true) {
            str_contains($pair, 'JPY')   => 3,
            str_contains($pair, 'XAU') || str_contains($pair, 'XAG') => 2,
            str_contains($pair, 'BTC') || str_contains($pair, 'ETH') => 1,
            str_contains($pair, 'NAS') || str_contains($pair, 'US30') => 1,
            default                       => 5,
        };
    }
}
