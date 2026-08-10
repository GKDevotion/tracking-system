<?php

namespace App\Http\Controllers;

use App\Models\TelegramPrivateSignal;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function privateChannelWebhook(Request $request)
    {
        $post = $request->input('channel_post');

        if (!$post) {
            return response()->json([
                'status' => 'ignored'
            ]);
        }

        $chatId = $post['chat']['id'] ?? null;
        $messageId = $post['message_id'] ?? null;
        $text = $post['text'] ?? '';

        if ($chatId != config('services.telegram.channel_id')) {
            return response()->json([
                'status' => 'invalid_channel'
            ]);
        }

        $signal = $this->parseSignal($text);

        if (!$signal) {
            return response()->json([
                'status' => 'not_signal'
            ]);
        }

        TelegramPrivateSignal::updateOrCreate(
            [
                'telegram_message_id' => $messageId,
                'channel_id' => $chatId,
            ],
            [
                'symbol' => $signal['symbol'],
                'direction' => $signal['direction'],
                'entry' => $signal['entry'],
                'stop_loss' => $signal['stop_loss'],
                'take_profit_1' => $signal['take_profit_1'],
                'take_profit_2' => $signal['take_profit_2'],
                'raw_message' => $text,
            ]
        );

        return response()->json([
            'status' => 'success'
        ]);
    }

    private function parseSignal(string $text)
    {
        preg_match(
            '/([A-Z]{6})\s+(BUY|SELL)/i',
            $text,
            $symbolMatch
        );

        preg_match(
            '/Entry\s*:\s*([0-9.]+)/i',
            $text,
            $entryMatch
        );

        preg_match(
            '/SL\s*:\s*([0-9.]+)/i',
            $text,
            $slMatch
        );

        preg_match(
            '/TP1\s*:\s*([0-9.]+)/i',
            $text,
            $tp1Match
        );

        preg_match(
            '/TP2\s*:\s*([0-9.]+)/i',
            $text,
            $tp2Match
        );

        if (!$symbolMatch || !$entryMatch) {
            return null;
        }

        return [
            'symbol' => strtoupper($symbolMatch[1]),
            'direction' => strtoupper($symbolMatch[2]),
            'entry' => $entryMatch[1] ?? null,
            'stop_loss' => $slMatch[1] ?? null,
            'take_profit_1' => $tp1Match[1] ?? null,
            'take_profit_2' => $tp2Match[1] ?? null,
        ];
    }
}
