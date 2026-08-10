<?php

namespace App\Services\Telegram;

use DOMDocument;
use DOMElement;
use DOMXPath;
use RuntimeException;

class TelegramScraper
{
    /**
     * Fetch telegram signals
     */
    public static function scrape(
        string $channel,
        ?int $afterId = null,
        int $maxPages = 30
    ): array {

        $results = [];

        for ($page = 0; $page < $maxPages; $page++) {

            $html = self::fetchPage($channel, $afterId);

            $messages = self::extractMessages($html);

            if (empty($messages)) {
                break;
            }

            $lowestId = null;

            foreach ($messages as $message) {

                $lowestId = $lowestId === null
                    ? $message['msg_id']
                    : min($lowestId, $message['msg_id']);

                // $signal = TelegramSignalParser::parseSignal($message['signal_text']);
                // $result = TelegramSignalParser::parseResult($message['result_text']);

                $signal = TelegramSignalParser::parseSignal(
                    $message['signal_text']
                );

                if (!$signal) {
                    continue;
                }

                $result = TelegramSignalParser::parseResult(
                    $message['result_text']
                );

                if( !$result ) {
                    continue;
                }

                TelegramSignalSaver::save(
                    signal: $signal,
                    result: $result,
                    postId: $message['post_id'],
                    msgId: $message['msg_id'],
                    datetime: $message['datetime']
                );

                $results[] = $message['msg_id'];
            }

            if (!$lowestId) {
                break;
            }

            $afterId = $lowestId;
        }

        return $results;
    }

    /**
     * Download telegram page
     */
    protected static function fetchPage(
        string $channel,
        ?int $afterId
    ): string {

        echo $url = "https://t.me/s/" . urlencode($channel);
die;
        if ($afterId) {
            $url .= "?after={$afterId}";
        }

        $ch = curl_init($url);

        curl_setopt_array($ch, [

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT =>
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept-Language: en-US,en;q=0.9'
            ]
        ]);

        $html = curl_exec($ch);

        $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $error = curl_error($ch);

        curl_close($ch);

        if (!$html || $http != 200) {

            throw new RuntimeException(
                "Telegram fetch failed ({$http}) {$error}"
            );
        }

        return $html;
    }

    /**
     * Extract every telegram message
     */
    protected static function extractMessages(
        string $html
    ): array {

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();

        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $nodes = $xpath->query(
            "//div[contains(@class,'tgme_widget_message') and @data-post]"
        );

        $messages = [];

        foreach ($nodes as $node) {

            /** @var DOMElement $node */

            $postId = $node->getAttribute('data-post');

            if (!$postId) {
                continue;
            }

            $msgId = (int) substr(
                $postId,
                strrpos($postId, '/') + 1
            );

            $timeNode = $xpath
                ->query(".//time[@datetime]", $node)
                ->item(0);

            $textNodes = $xpath->query(
                ".//div[contains(@class,'tgme_widget_message_text')]",
                $node
            );

            $signalText = '';

            $resultText = '';

            if ($textNodes->length > 0) {

                $signalText = self::normalizeText(
                    $textNodes->item(0)->textContent
                );
            }

            if ($textNodes->length > 1) {

                $resultText = self::normalizeText(
                    $textNodes->item(1)->textContent
                );
            }

            $messages[] = [

                'post_id' => $postId,

                'msg_id' => $msgId,

                'signal_text' => $signalText,

                'result_text' => $resultText,

                'datetime' => $timeNode
                    ? $timeNode->getAttribute('datetime')
                    : null,

            ];
        }

        return $messages;
    }

    /**
     * Clean telegram text
     */
    protected static function normalizeText(
        ?string $text
    ): string {

        if (!$text) {
            return '';
        }

        $text = html_entity_decode($text);

        $text = preg_replace('/\R/u', "\n", $text);

        $text = preg_replace('/\h+/u', ' ', $text);

        $text = preg_replace('/\n+/u', "\n", $text);

        return trim($text);
    }

    /**
     * Fetch telegram deleted signals
     */
    public static function scrapeDeleted(
        string $channel,
        ?int $afterId = null,
        int $maxPages = 20
    ): array {

        $resultIds = [];

        // for ($page = 0; $page < $maxPages; $page++) {

            $html = self::fetchPage($channel, $afterId);

            $messages = self::extractMessages($html);

            // if (empty($messages)) {
            //     break;
            // }

            foreach ($messages as $message) {
                $resultIds[] = $message['msg_id'];
            }
        // }

        return $resultIds;
    }
}
