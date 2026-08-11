<?php

namespace App\Services;

class TelegramPrivateSignalParser
{
    public function parseSignal(string $text): ?array
    {
        $text = trim($text);

        if ($text === '') {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Symbol
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/\b(XAUUSD|XAGUSD|EURUSD|GBPUSD|USDJPY|USDCHF|AUDUSD|USDCAD|NZDUSD|NAS100|US30|SPX500|BTCUSD|ETHUSD)\b/i',
            $text,
            $symbolMatch
        );

        $symbol = isset($symbolMatch[1])
            ? strtoupper($symbolMatch[1])
            : null;

        /*
        |--------------------------------------------------------------------------
        | Direction
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/\b(BUY|SELL)\b/i',
            $text,
            $directionMatch
        );

        $direction = isset($directionMatch[1])
            ? strtoupper($directionMatch[1])
            : null;

        /*
        |--------------------------------------------------------------------------
        | Entry
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/(?:Entry|ENTRY)\s*[:\-]?\s*([0-9]+(?:\.[0-9]+)?)/i',
            $text,
            $entryMatch
        );

        $entry = $entryMatch[1] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Stop Loss
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/(?:SL|Stop\s*Loss)\s*[:\-]?\s*([0-9]+(?:\.[0-9]+)?)/i',
            $text,
            $slMatch
        );

        $stopLoss = $slMatch[1] ?? null;

        /*
        |--------------------------------------------------------------------------
        | TP1
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/(?:TP1|TP\s*1)\s*[:\-]?\s*(Open|[0-9]+(?:\.[0-9]+)?)/i',
            $text,
            $tp1Match
        );

        $tp1 = $tp1Match[1] ?? null;

        /*
        |--------------------------------------------------------------------------
        | TP2
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/(?:TP2|TP\s*2)\s*[:\-]?\s*(Open|[0-9]+(?:\.[0-9]+)?)/i',
            $text,
            $tp2Match
        );

        $tp2 = $tp2Match[1] ?? null;

        /*
        |--------------------------------------------------------------------------
        | TP3
        |--------------------------------------------------------------------------
        */

        preg_match(
            '/(?:TP3|TP\s*3)\s*[:\-]?\s*(Open|[0-9]+(?:\.[0-9]+)?)/i',
            $text,
            $tp3Match
        );

        $tp3 = $tp3Match[1] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Is this actually a signal?
        |--------------------------------------------------------------------------
        */

        if (!$symbol || !$direction || !$entry) {
            return null;
        }

        return [
            'symbol' => $symbol,
            'direction' => $direction,
            'entry' => $this->numericValue($entry),
            'stop_loss' => $this->numericValue($stopLoss),
            'take_profit_1' => $this->numericValue($tp1),
            'take_profit_2' => $this->numericValue($tp2),
            'take_profit_3' => $this->numericValue($tp3),
        ];
    }

    private function numericValue(?string $value): ?float
    {
        if (!$value || strtolower($value) === 'open') {
            return null;
        }

        return (float) $value;
    }

    public function detectUpdateType(string $text): string
    {
        $textLower = strtolower($text);

        /*
        |--------------------------------------------------------------------------
        | SL HIT
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($textLower, 'sl hit') ||
            str_contains($textLower, 'stop loss hit') ||
            str_contains($textLower, 'stoploss hit')
        ) {
            return 'SL_HIT';
        }

        /*
        |--------------------------------------------------------------------------
        | TP HIT
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($textLower, 'tp1 hit') ||
            str_contains($textLower, 'tp 1 hit')
        ) {
            return 'TP1_HIT';
        }

        if (
            str_contains($textLower, 'tp2 hit') ||
            str_contains($textLower, 'tp 2 hit')
        ) {
            return 'TP2_HIT';
        }

        if (
            str_contains($textLower, 'tp3 hit') ||
            str_contains($textLower, 'tp 3 hit')
        ) {
            return 'TP3_HIT';
        }

        /*
        |--------------------------------------------------------------------------
        | SL moved
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($textLower, 'sl moved') ||
            str_contains($textLower, 'move sl') ||
            str_contains($textLower, 'sl to entry')
        ) {
            return 'SL_MOVED';
        }

        /*
        |--------------------------------------------------------------------------
        | Trade closed
        |--------------------------------------------------------------------------
        */

        if (
            str_contains($textLower, 'trade closed') ||
            str_contains($textLower, 'closed trade')
        ) {
            return 'TRADE_CLOSED';
        }

        return 'TRADE_UPDATE';
    }

    public function extractPips(string $text): ?float
    {
        /*
        Examples:

        +149 PIPS
        -90 PIPS
        +20 pips
        90 PIPS
        */

        preg_match(
            '/([+\-−]?\s*[0-9]+(?:\.[0-9]+)?)\s*PIPS/i',
            $text,
            $matches
        );

        if (!isset($matches[1])) {
            return null;
        }

        $value = str_replace(
            [' ', '−'],
            ['', '-'],
            $matches[1]
        );

        return (float) $value;
    }
}
