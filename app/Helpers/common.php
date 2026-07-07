
<?php

use App\Models\Configuration;
use App\Models\ForexUpdate;
use Illuminate\Support\Carbon;

if (!function_exists('getConfigurationField')) {
    /**
     * Get configuration value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getConfigurationField($key, $default = null)
    {
        $config = Configuration::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

     function getConfigurationDisplayName($key)
    {
        return \App\Models\Configuration::where('key', $key)
            ->value('display_name');
    }
}

/**
 * Telegram Public Channel Signal Scraper
 * Source: https://t.me/s/{channel}  (no login required, public preview only)
 *
 * Extracts: Pair, Entry range, SL, TP1-3, message unique link, timestamp
 *
 * Usage:
 *   php telegram_signal_scraper.php
 *   or include and call scrapeTelegramSignals('Wealthoraofficial');
 */

/**
 * Scrape signals within a date window (default: today + yesterday) by
 * paginating backward through t.me/s/{channel}?before={msg_id}.
 *
 * @param string $channel
 * @param int    $daysBack   0 = today only, 1 = today + yesterday, etc.
 * @param int    $maxPages   safety cap on how many pages to walk back (each page ~20 msgs)
 */
function scrapeTelegramSignals(string $channel, $afterId = null, int $maxPages = 15): array
{
    $results = [];
    $reachedCutoff = false;

    for ($page = 0; $page < $maxPages && !$reachedCutoff; $page++) {
        $url = "https://t.me/s/" . urlencode($channel) . ($afterId ? "?after={$afterId}" : '');

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36',
            CURLOPT_HTTPHEADER => ['Accept-Language: en-US,en;q=0.9'],
        ]);

        $html = curl_exec($ch);
        $err  = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($html === false || $httpCode !== 200) {
            throw new RuntimeException("Fetch failed (HTTP {$httpCode}): {$err}");
        }

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $messageNodes = $xpath->query("//div[contains(@class, 'tgme_widget_message') and @data-post]");

        if ($messageNodes->length === 0) {
            break; // no more pages / empty channel
        }

        $lowestIdOnPage = null;

        // Nodes come in ascending order (oldest -> newest) on each page
        foreach ($messageNodes as $node) {

            /** @var DOMElement $node */
            $postId = $node->getAttribute('data-post'); // e.g. "Wealthoraofficial/1234"
            if (!$postId) continue;

            $msgId = (int) substr($postId, strrpos($postId, '/') + 1);
            if ($lowestIdOnPage === null || $msgId < $lowestIdOnPage) {
                $lowestIdOnPage = $msgId;
            }

            $textNode = $xpath->query(".//div[contains(@class,'tgme_widget_message_text')]", $node)->item(0);
            $rawText = $textNode ? trim($textNode->textContent) : '';
            $text = preg_replace('/\s*\n\s*/', "\n", $rawText);
            $text = preg_replace('/[ \t]+/', ' ', $text);

            if ($text === '') continue;

            $timeNode = $xpath->query(".//time[@datetime]", $node)->item(0);
            $parsed = parseSignal($text, $postId, $timeNode, $msgId);
            if (!$parsed) continue; // skip non-signal messages (comments, TP-hit updates, etc.)

            $parsed['link'] = "https://t.me/{$postId}";
            $parsed['raw_text'] = $text;
            // $parsed['raw_text'] = $msgId;

            // if( $msgId == 346 ) {
            //     dd( $node, $parsed, $afterId );
            // }

            $results[] = $parsed;//"https://t.me/{$postId}";
        }

        if ($lowestIdOnPage === null) break;
        $afterId = $lowestIdOnPage; // next page walks further back in history
    }

    return $results;
}

function parseSignal(string $text, string $postId, object $timeNode, int $msgId): ?array
{
    // Pair + direction, e.g. "EUR/GBP BUY Setup" or "CAD/JPY SELL Setup"
    if (preg_match('/(BUY|SELL)/i', $text, $stringMatch)) {

        $pairMatch = [];
        if (preg_match('/([A-Z]{3})\/([A-Z]{3})/i', $text, $pairMatch)) {
            // dd( "here", $pairMatch );
            $pairMatch = $pairMatch;
        }

    // dd( $pairMatch, $stringMatch, $text, $postId, $timeNode, $msgId );

        $live_btn_url = "https://t.me/{$postId}";
        $pips = null;
        $pair = strtoupper($pairMatch[0]);
        $direction = strtoupper($stringMatch[0]);

        // Entry range, e.g. "Entry: 0.8642 – 0.8632" or "Entry: 114.55"
        // preg_match('/Entry:\s*([\d.]+)\s*[-–]\s*([\d.]+)/i', $text, $entryMatch);
        // dd( $msgId, $text, $entryMatch );
        // $entryFrom = $entryMatch[1] ?? null;
        // // $entryTo   = $entryMatch[2] ?? null;
        if (preg_match('/Entry:\s*([\d.]+)(?:\s*[-–]\s*([\d.]+))?/i', $text, $entryMatch)) {

            $entryPrices = array_filter([
                $entryMatch[1] ?? null,
                $entryMatch[2] ?? null,
            ]);

            // Example:
            // ["0.8642", "0.8632"]
            // or
            // ["114.55"]
        }

        dd( $entryMatch );
        $entryFrom = $entryPrices[0] ?? null;
        $entryTo   = $entryPrices[1] ?? null;


        // SL
        preg_match('/SL:\s*([\d.]+)/i', $text, $slMatch);
        $sl = $slMatch[1] ?? null;

        // TP1, TP2, TP3 (individually, order-agnostic)
        preg_match('/TP1:\s*([\d.]+)/i', $text, $tp1Match);
        preg_match('/TP2:\s*([\d.]+)/i', $text, $tp2Match);
        preg_match('/TP3:\s*([\d.]+)/i', $text, $tp3Match);

        // Require at least entry or SL to consider this a real signal (filters out pure text updates)
        if (!$entryFrom && !$sl) {
            return null;
        }

        /**
         * check old signal exist and hit profit or loss
         */
        $result_id = null;
        $result_date = null;
        $fetchOldData = false;
        if (preg_match('/hit\s*:\s*([+-]?\d+(?:\.\d+)?)\s*pips/i', $text, $matches)) {// Hit Profit: +15 pips
            $pips = $matches[1];
            $fetchOldData = true;
        } elseif (preg_match('/hit\s+tp\s*:\s*([+-]?\d+(?:\.\d+)?)\s*pips/i', $text, $matches)) {// Hit Loss: -10 pips
            $pips = $matches[1];
            $fetchOldData = true;
        }

        //get oparent signal id and date
        if( $fetchOldData ) {

            $oldSignal = ForexUpdate::where('live_btn_url', '!=', $live_btn_url)
                ->where(
                    [
                        'pair' => $pair,
                        'order_type' => ($direction == "SELL") ? 1 : 0,
                        'status' => 1,
                        'entry_price' => $entryFrom,
                        'stop_loss' => $sl ?? 0,
                    ]
                )
                ->whereJsonContains('take_profit', [$tp1Match[1] ?? null, $tp2Match[1] ?? null, $tp3Match[1] ?? null])
                ->first();

            if( $oldSignal ) {
                $result_id = $oldSignal->id;
                $result_date = Carbon::parse($timeNode->getAttribute('datetime'))->format('Y-m-d');
                $live_btn_url = $oldSignal->live_btn_url ?? $live_btn_url;
            }
        }

        //store the parsed signal in the database
        ForexUpdate::updateOrCreate(

            // Check existing record by this column
            [
                'live_btn_url' => $live_btn_url,
            ],

            // Values to insert/update
            [
                'signal_date' => $timeNode ? Carbon::parse($timeNode->getAttribute('datetime'))->format('Y-m-d') : null,
                'pair' => $pair ?? null,
                'order_type' => ( $direction == "SELL" ) ? 1 : 0,
                'entry_price' => $entryFrom ?? 0,
                'stop_loss' => $sl ?? 0,
                'take_profit' => json_encode([
                    $tp1Match[1] ?? null,
                    $tp2Match[1] ?? null,
                    $tp3Match[1] ?? null,
                ], 1),
                'profit' => $pips ?? null,
                'sort_order' => 0,
                'status' => 1,
                'post_id' => $msgId,
                'result_id' => $result_id,
                'result_date' => $result_date,
            ]
        );

        return [
            'pair'       => $pair,
            'entry_from' => $entryFrom,
            'sl'         => $sl,
            'tp1'        => $tp1Match[1] ?? null,
            'tp2'        => $tp2Match[1] ?? null,
            'tp3'        => $tp3Match[1] ?? null,
            'pips'       => $pips ?? null,
        ];
        // return [
        //     'pair'       => $pair,
        //     'direction'  => $direction,
        //     'entry_from' => $entryFrom,
        //     'entry_to'   => $entryTo,
        //     'sl'         => $sl,
        //     'tp1'        => $tp1Match[1] ?? null,
        //     'tp2'        => $tp2Match[1] ?? null,
        //     'tp3'        => $tp3Match[1] ?? null,
        //     'pips'       => $pips ?? null,
        // ];
    }


}

function _parseSignal(string $text): ?array
{
    // Pair + direction, e.g. "EUR/GBP BUY Setup" or "CAD/JPY SELL Setup"
    if (!preg_match('/([A-Z]{3}\/[A-Z]{3})\s+(BUY|SELL)/i', $text, $pairMatch)) {
        return null;
    }

    $pair = strtoupper($pairMatch[1]);
    $direction = strtoupper($pairMatch[2]);

    // Entry range, e.g. "Entry: 0.8642 – 0.8632" or "Entry: 114.55 - 114.65"
    preg_match('/Entry:\s*([\d.]+)\s*[-–]\s*([\d.]+)/i', $text, $entryMatch);
    $entryFrom = $entryMatch[1] ?? null;
    $entryTo   = $entryMatch[2] ?? null;

    // SL
    preg_match('/SL:\s*([\d.]+)/i', $text, $slMatch);
    $sl = $slMatch[1] ?? null;

    // TP1, TP2, TP3 (individually, order-agnostic)
    preg_match('/TP1:\s*([\d.]+)/i', $text, $tp1Match);
    preg_match('/TP2:\s*([\d.]+)/i', $text, $tp2Match);
    preg_match('/TP3:\s*([\d.]+)/i', $text, $tp3Match);

    // Require at least entry or SL to consider this a real signal (filters out pure text updates)
    if (!$entryFrom && !$sl) {
        return null;
    }

    return [
        'pair'       => $pair,
        'direction'  => $direction,
        'entry_from' => $entryFrom,
        'entry_to'   => $entryTo,
        'sl'         => $sl,
        'tp1'        => $tp1Match[1] ?? null,
        'tp2'        => $tp2Match[1] ?? null,
        'tp3'        => $tp3Match[1] ?? null,
    ];
}
