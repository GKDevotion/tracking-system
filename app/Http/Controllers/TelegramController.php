<?php

namespace App\Http\Controllers;

use App\Models\TelegramPrivateSignal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function testWebhook(Request $request)
    {
        Log::channel('daily')->info('TELEGRAM WEBHOOK HIT');

        Log::channel('daily')->info(
            'TELEGRAM DATA',
            $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => 'Webhook received'
        ]);
    }

    public function privateChannelWebhook(Request $request)
    {
        Log::info('Telegram Signal Processing', [
            $request->all()
        ]);

        try{
            $post = $request->input('channel_post');

            if (!$post) {
                return response()->json([
                    'status' => 'ignored'
                ]);

            }//1003746642220

            $chatId = $post['chat']['id'] ?? null;
            $messageId = $post['message_id'] ?? null;
            $text = $post['text'] ?? '';

            $tgChatIds = [
                "-3746642220", // Wealthora Signals VIP
                // "-1004411633101", // Wealthora Signals Free
            ];

            if (!in_array($chatId, $tgChatIds)) {
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
        } catch ( Exception $e) {
            Log::error('Telegram Signal Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
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
