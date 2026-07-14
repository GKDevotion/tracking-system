<?php

namespace App\Services\Telegram;

class TelegramSignalParser
{
    /**
     * Parse new signal
     */
    public static function parseSignal(string $text): ?array
    {
        $text = trim($text);

        if ($text == '') {
            return null;
        }

        $direction = self::extractDirection($text);

        if (!$direction) {
            return null;
        }

        $pair = self::extractPair($text);

        if (!$pair) {
            return null;
        }

        $entry = self::extractEntry($text);

        $sl = self::extractSL($text);

        $tp = self::extractTakeProfits($text);

        return [

            'pair' => $pair,

            'direction' => $direction,

            'entry_price' => $entry[0] ?? null,

            'entry_range' => $entry,

            'stop_loss' => $sl,

            'take_profit' => $tp,

        ];
    }

    /**
     * Parse Result Message
     *
     * HIT
     * HIT TP
     * HIT SL
     */
    public static function parseResult(string $text): ?array
    {
        $text = trim($text);

        if ($text == '') {
            return null;
        }

        $patterns = [

            'SL' => '/hit\s+sl\s*:\s*([+-]?\d+(?:\.\d+)?)\s*pips/i',
            'TP' => '/hit\s+tp\s*:\s*([+-]?\d+(?:\.\d+)?)\s*pips/i',
            'HIT_0' => '/hit\s*:\s*([+-]?\d+(?:\.\d+)?)\s*pips/i',
            'HIT_1' => '/(?:pips?\s*)?hit\s*:?\s*([+-]?\d+(?:\.\d+)?)\s*pips?/i',

        ];

        foreach ($patterns as $type => $regex) {

            if (preg_match($regex, $text, $match)) {

                if( $type == "HIT_0" || $type == "HIT_1" ){
                    $type = "HIT";
                }

                return [
                    'type' => $type,
                    'profit' => $match[1],
                ];
            }
        }

        return null;
    }

    /**
     * EUR/USD
     * NAS100
     * XAU/USD
     * BTC/USD
     */
    public static function extractPair(string $text): ?string
    {
        if (preg_match('/^([A-Z]{2,10}(?:\/[A-Z]{2,10})?\d*)\b/i', trim($text), $m)) {

            return strtoupper($m[1]);
        }

        return null;
    }

    /**
     * BUY / SELL
     */
    public static function extractDirection(string $text): ?string
    {
        if (preg_match('/\b(BUY|SELL)\b/i', $text, $m)) {

            return strtoupper($m[1]);
        }

        return null;
    }

    /**
     * Entry
     *
     * 1.1234
     *
     * 1.1234 - 1.1220
     */
    public static function extractEntry(string $text): array
    {
        if (preg_match('/Entry:\s*([\d.]+)(?:\s*[-–]\s*([\d.]+))?/i', $text, $m)) {

            return array_values(array_filter([

                $m[1] ?? null,

                $m[2] ?? null,

            ]));
        }

        return [];
    }

    /**
     * Stop Loss
     */
    public static function extractSL(string $text): ?string
    {
        if (preg_match('/SL:\s*([\d.]+)/i', $text, $m)) {

            return $m[1];
        }

        return null;
    }

    /**
     * TP1 TP2 TP3
     */
    public static function extractTakeProfits(string $text): array
    {
        $tp = [];

        preg_match('/TP1:\s*([\d.]+)/i', $text, $m1);

        preg_match('/TP2:\s*([\d.]+)/i', $text, $m2);

        preg_match('/TP3:\s*([\d.]+)/i', $text, $m3);

        if (!empty($m1[1])) {
            $tp[] = $m1[1];
        }

        if (!empty($m2[1])) {
            $tp[] = $m2[1];
        }

        if (!empty($m3[1])) {
            $tp[] = $m3[1];
        }

        return $tp;
    }
}
