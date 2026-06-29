<?php
namespace App\Services;

use App\Models\Signal;
use App\Models\MT5Trade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MT5BridgeService
{
    private string $bridgeUrl;
    private string $secret;

    public function __construct()
    {
        $this->bridgeUrl = config('services.mt5.bridge_url');
        $this->secret    = config('services.mt5.secret');
    }

    /**
     * Submit an approved signal to MT5 for auto-execution.
     */
    public function submitSignal(Signal $signal, float $lots = 0.01): array
    {
        Log::channel('telegram')->info('📡 MT5 SUBMIT START', [
            'signal_id' => $signal->id,
            'pair'      => $signal->pair,
            'direction' => $signal->direction,
            'bridge_url'=> $this->bridgeUrl,
        ]);

        $payload = [
            'secret'    => $this->secret,
            'signal_id' => $signal->id,
            'pair'      => $signal->pair,
            'direction' => $signal->direction,
            'entry_min' => (float) $signal->entry_min,
            'entry_max' => (float) ($signal->entry_max ?? $signal->entry_min),
            'sl'        => (float) $signal->sl,
            'tp1'       => (float) ($signal->tp1 ?? 0),
            'tp2'       => (float) ($signal->tp2 ?? 0),
            'tp3'       => (float) ($signal->tp3 ?? 0),
            'lots'      => $lots,
        ];

        try {
            $response = $this->http()->timeout(10)->post($this->bridgeUrl, $payload);
            $data     = $response->json();

            Log::channel('telegram')->info('📡 MT5 BRIDGE RESPONSE', ['data' => $data]);

            if ($response->ok() && ($data['ok'] ?? false)) {
                // Store the MT5 trade record
                MT5Trade::create([
                    'signal_id'  => $signal->id,
                    'ticket'     => $data['ticket'] ?? null,
                    'pair'       => $signal->pair,
                    'direction'  => $signal->direction,
                    'lots'       => $lots,
                    'entry'      => (float) $signal->entry_min,
                    'sl'         => (float) $signal->sl,
                    'tp1'        => (float) ($signal->tp1 ?? 0),
                    'status'     => 'open',
                    'raw_response' => json_encode($data),
                ]);

                Log::channel('telegram')->info('✅ MT5 TRADE PLACED', [
                    'signal_id' => $signal->id,
                    'ticket'    => $data['ticket'] ?? null,
                ]);

                return ['ok' => true, 'ticket' => $data['ticket'] ?? null];
            }

            Log::channel('telegram')->error('❌ MT5 BRIDGE ERROR RESPONSE', ['data' => $data]);
            return ['ok' => false, 'error' => $data['error'] ?? 'Unknown error'];

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 MT5 BRIDGE EXCEPTION', [
                'signal_id' => $signal->id,
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    private function http(): \Illuminate\Http\Client\PendingRequest
    {
        $request = Http::withHeaders(['Content-Type' => 'application/json']);

        // Only disable SSL verification in local/dev — never in production
        if (app()->environment('local')) {
            $request = $request->withoutVerifying();
        }

        return $request;
    }
}
