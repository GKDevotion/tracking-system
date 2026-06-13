<?php
namespace App\Services;

use App\Models\Signal;
use App\Models\SignalResult;

class MessageFormatterService
{
    // Invisible spacer used in Telegram to preserve blank lines
    private const SPACER = "ㅤ";

    public function formatSignal(Signal $signal): string
    {
        $entry = $signal->entry_max
            ? "{$signal->entry_min} – {$signal->entry_max}"
            : (string) $signal->entry_min;

        $lines = [
            "📊 *{$signal->pair} {$signal->direction} Setup*",
            self::SPACER,
            "📍 Entry: `{$entry}`",
            "🛑 SL: `{$signal->sl}`",
            self::SPACER,
        ];

        if ($signal->tp1) $lines[] = "🎯 TP1: `{$signal->tp1}`";
        if ($signal->tp2) $lines[] = "🎯 TP2: `{$signal->tp2}`";
        if ($signal->tp3) $lines[] = "🎯 TP3: `{$signal->tp3}`";

        return implode("\n", $lines);
    }

    public function formatResult(SignalResult $result): string
    {
        $signal = $result->signal;
        $pips   = $result->pips_points;
        $abs    = abs($pips);
        $unit   = $this->unit($signal->pair);

        return match ($result->result_type) {
            'T1' => implode("\n", [
                "✅ *TP1 HIT:* *+{$abs} {$unit}*",
                "🔒 *SL moved to Entry*",
                self::SPACER,
                "Clean setup. Risk protected.",
            ]),
            'T2' => implode("\n", [
                "✅ *TP2 HIT:* *+{$abs} {$unit}*",
                "🔒 *SL secured in profit*",
                self::SPACER,
                "Patience paid. Setup delivered.",
            ]),
            'T3' => implode("\n", [
                "✅ *TP3 HIT:* *+{$abs} {$unit}*",
                self::SPACER,
                "Perfect execution. Complete move captured.",
            ]),
            'SL' => implode("\n", [
                "⚠️ *TRADE CLOSED*",
                self::SPACER,
                "*{$signal->pair} {$signal->direction}* hit SL: *-{$abs} {$unit}*",
                self::SPACER,
                "Loss is part of trading. We don't hide losses.",
                self::SPACER,
                "✅ Risk controlled  ✅ SL respected  ✅ No revenge trade",
                self::SPACER,
                "Wait for the next *high-probability setup* 👍",
            ]),
            'BE' => implode("\n", [
                "🔒 *RISK PROTECTED*",
                self::SPACER,
                "*{$signal->pair} {$signal->direction}*",
                self::SPACER,
                "SL moved to *Entry / Breakeven*",
                self::SPACER,
                "Now the trade is protected. Let the market do the rest.",
            ]),
            default => '',
        };
    }

    private function unit(string $pair): string
    {
        $points = ['XAU','XAG','NAS','US30','SPX','BTC','ETH','OIL'];
        foreach ($points as $p) {
            if (str_contains(strtoupper($pair), $p)) return 'POINTS';
        }
        return 'PIPS';
    }
}
