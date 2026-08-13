<?php

namespace App\Http\Controllers;

use App\Models\ForexUpdate;
use App\Models\TelegramPrivateSignal;
use App\Models\TelegramPrivateSignalUpdate;
use App\Services\Telegram\TelegramPrivateSignalParser;
use App\Services\Telegram\TelegramSignalParser;
use App\Services\Telegram\TelegramSignalSaver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramController extends Controller
{
    public function __construct(
        protected TelegramPrivateSignalParser $parser
    ) {
    }

    public function privateChannelWebhook(Request $request)
    {
        $update = $request->all();

        if (isset($update[0]) && is_array($update[0])) {
            $update = $update[0];
        }

        Log::info('Telegram Signal Processing', $update);

        try {

            /*
            |--------------------------------------------------------------------------
            | Get channel post
            |--------------------------------------------------------------------------
            */

            $channelPost =
                $update['channel_post']
                ?? $update['edited_channel_post']
                ?? null;

            if (!$channelPost) {
                return response()->json([
                    'success' => true,
                    'message' => 'No channel post'
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Channel information
            |--------------------------------------------------------------------------
            */

            $channelId = $channelPost['chat']['id'] ?? null;

            $expectedChannelId =
                config('services.telegram.private_channel_id');

            /*
            |--------------------------------------------------------------------------
            | Security check
            |--------------------------------------------------------------------------
            */

            if (
                !$channelId ||
                (string) $channelId !==
                (string) $expectedChannelId
            ) {

                Log::warning('Telegram invalid channel', [
                    'received' => $channelId,
                    'expected' => $expectedChannelId,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid channel'
                ], 403);
            }

            /*
            |--------------------------------------------------------------------------
            | Telegram message information
            |--------------------------------------------------------------------------
            */

            if( true ){

                $datetime = null;

                if( isset( $channelPost['reply_to_message']['message_id'] ) &&  $channelPost['reply_to_message']['message_id'] > 0 ){
                    $result = TelegramSignalParser::parseResult(
                        $channelPost['text']
                    );

                    if( $result ) {

                        if (!empty($channelPost['reply_to_message']['date'])) {
                            $datetime = date( 'Y-m-d H:i:s', $channelPost['reply_to_message']['date'] );
                        }

                        ForexUpdate::where([
                            'ticket' => "3746642220",
                            'post_id'=> $channelPost['reply_to_message']['message_id']
                        ])
                        ->update([
                            // 'signal_date'  => $datetime,
                            // 'pair'         => $signal['pair'],
                            // 'order_type'   => $signal['direction'] == 'SELL' ? 1 : 0,
                            // 'entry_price'  => $signal['entry_price'],
                            // 'stop_loss'    => $signal['stop_loss'],
                            // 'take_profit'  => json_encode($signal['take_profit']),
                            'profit'       => $result['profit'] ?? null,
                            'status'       => 1,
                            // 'sort_order'   => 0,
                            'ticket' => "3746642220",
                            'result_id'    => $channelPost['message_id'],
                            'result_date'  => $datetime,
                        ]);
                    }
                } else {

                    $signal = TelegramSignalParser::parseSignal(
                        $channelPost['text']
                    );

                    if (!empty($channelPost['date'])) {
                        $datetime = date( 'Y-m-d H:i:s', $channelPost['date'] );
                    }

                    ForexUpdate::create([
                        'post_id'      => $channelPost['message_id'],
                        'signal_date'  => $datetime,
                        'pair'         => $signal['pair'],
                        'order_type'   => $signal['direction'] === 'SELL' ? 1 : 0,
                        'entry_price'  => $signal['entry_price'],
                        'stop_loss'    => $signal['stop_loss'],
                        'take_profit'  => json_encode($signal['take_profit']),
                        'profit'       => $result['profit'] ?? null,
                        'status'       => 1,
                        'sort_order'   => 0,
                        'result_id'    => null,
                        'result_date'  => null,
                        'ticket'       => "3746642220",
                        'live_btn_url' => "https://t.me/c/3746642220/".$channelPost['message_id']
                    ]);
                }
            } else {
                $messageId = $channelPost['message_id'] ?? null;

                $replyToMessageId = $channelPost['reply_to_message']['message_id'] ?? null;

                $text = $channelPost['text'] ?? $channelPost['caption'] ?? '';

                /*
                |--------------------------------------------------------------------------
                | Telegram date
                |--------------------------------------------------------------------------
                */

                $telegramDate = null;

                if (!empty($channelPost['date'])) {
                    $telegramDate =
                        date(
                            'Y-m-d H:i:s',
                            $channelPost['date']
                        );
                }

                /*
                |--------------------------------------------------------------------------
                | Current message is a reply?
                |--------------------------------------------------------------------------
                */

                if ($replyToMessageId) {

                    return $this->processReplyMessage(
                        channelId: $channelId,
                        messageId: $messageId,
                        replyToMessageId: $replyToMessageId,
                        text: $text,
                        channelPost: $channelPost,
                        telegramDate: $telegramDate
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Normal message
                |--------------------------------------------------------------------------
                */

                return $this->processNormalMessage(
                    channelId: $channelId,
                    messageId: $messageId,
                    text: $text,
                    channelPost: $channelPost,
                    telegramDate: $telegramDate
                );
            }

        } catch (Throwable $e) {

            Log::error(
                'Telegram webhook error',
                [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Important:
            | Return 200 to Telegram after logging the problem.
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => false,
                'message' => 'Webhook processed with error'
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Normal message
    |--------------------------------------------------------------------------
    */

    private function processNormalMessage(
        int $channelId,
        int $messageId,
        string $text,
        array $channelPost,
        ?string $telegramDate
    ) {
        /*
        |--------------------------------------------------------------------------
        | Check duplicate
        |--------------------------------------------------------------------------
        */

        $existing =
            TelegramPrivateSignal::where('channel_id', $channelId)
                ->where('telegram_message_id', $messageId)
                ->first();

        if ($existing) {

            Log::info('Telegram message already processed', [
                'message_id' => $messageId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Already processed'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Try to parse as signal
        |--------------------------------------------------------------------------
        */

        $signal =
            $this->parser->parseSignal($text);

        /*
        |--------------------------------------------------------------------------
        | Not a signal
        |--------------------------------------------------------------------------
        */

        if (!$signal) {

            Log::info('Telegram general message', [
                'message_id' => $messageId,
                'text' => $text,
            ]);

            /*
            |--------------------------------------------------------------------------
            | We can still store it as GENERAL.
            |--------------------------------------------------------------------------
            */

            TelegramPrivateSignal::create([
                'channel_id' => $channelId,
                'telegram_message_id' => $messageId,

                'symbol' => 'GENERAL',
                'direction' => 'BUY',

                'status' => 'CLOSED',
                'message_type' => 'GENERAL',

                'raw_message' => $text,
                'raw_payload' => json_encode(
                    $channelPost,
                    JSON_UNESCAPED_UNICODE
                ),

                'telegram_date' => $telegramDate,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'General message stored'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Store new signal
        |--------------------------------------------------------------------------
        */

        $record = TelegramPrivateSignal::create([

            'channel_id' => $channelId,

            'telegram_message_id' => $messageId,

            'reply_to_message_id' => null,

            'symbol' => $signal['symbol'],

            'direction' => $signal['direction'],

            'entry' => $signal['entry'],

            'stop_loss' => $signal['stop_loss'],

            'take_profit_1' => $signal['take_profit_1'],

            'take_profit_2' => $signal['take_profit_2'],

            'take_profit_3' => $signal['take_profit_3'],

            'status' => 'ACTIVE',

            'message_type' => 'SIGNAL',

            'raw_message' => $text,

            'raw_payload' => json_encode(
                $channelPost,
                JSON_UNESCAPED_UNICODE
            ),

            'telegram_date' => $telegramDate,
        ]);

        Log::info('New Telegram signal stored', [
            'id' => $record->id,
            'symbol' => $record->symbol,
            'direction' => $record->direction,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Signal stored',
            'signal_id' => $record->id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Reply message
    |--------------------------------------------------------------------------
    */

    private function processReplyMessage(
        int $channelId,
        int $messageId,
        int $replyToMessageId,
        string $text,
        array $channelPost,
        ?string $telegramDate
    ) {

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate update
        |--------------------------------------------------------------------------
        */

        $existingUpdate =
            TelegramPrivateSignalUpdate::where(
                'channel_id',
                $channelId
            )
            ->where(
                'telegram_message_id',
                $messageId
            )
            ->first();

        if ($existingUpdate) {

            return response()->json([
                'success' => true,
                'message' => 'Update already processed'
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Find original signal
        |--------------------------------------------------------------------------
        */

        $signal =
            TelegramPrivateSignal::where(
                'channel_id',
                $channelId
            )
            ->where(
                'telegram_message_id',
                $replyToMessageId
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | If direct parent isn't signal,
        | check if it points to another reply.
        |--------------------------------------------------------------------------
        */

        if (!$signal) {

            $parent =
                TelegramPrivateSignalUpdate::where(
                    'channel_id',
                    $channelId
                )
                ->where(
                    'telegram_message_id',
                    $replyToMessageId
                )
                ->first();

            if ($parent && $parent->signal_id) {
                $signal =
                    TelegramPrivateSignal::find(
                        $parent->signal_id
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | If old Telegram message was never received by webhook
        |--------------------------------------------------------------------------
        */

        if (!$signal) {

            $replyMessage =
                $channelPost['reply_to_message']
                ?? null;

            $originalText =
                $replyMessage['text']
                ?? $replyMessage['caption']
                ?? '';

            /*
            |--------------------------------------------------------------------------
            | Try to reconstruct original signal
            |--------------------------------------------------------------------------
            */

            if ($originalText !== '') {

                $parsed =
                    $this->parser->parseSignal(
                        $originalText
                    );

                if ($parsed) {

                    $signal =
                        TelegramPrivateSignal::create([

                            'channel_id' => $channelId,

                            'telegram_message_id' =>
                                $replyToMessageId,

                            'reply_to_message_id' => null,

                            'symbol' =>
                                $parsed['symbol'],

                            'direction' =>
                                $parsed['direction'],

                            'entry' =>
                                $parsed['entry'],

                            'stop_loss' =>
                                $parsed['stop_loss'],

                            'take_profit_1' =>
                                $parsed['take_profit_1'],

                            'take_profit_2' =>
                                $parsed['take_profit_2'],

                            'take_profit_3' =>
                                $parsed['take_profit_3'],

                            'status' => 'ACTIVE',

                            'message_type' => 'SIGNAL',

                            'raw_message' =>
                                $originalText,

                            'raw_payload' =>
                                json_encode(
                                    $replyMessage,
                                    JSON_UNESCAPED_UNICODE
                                ),

                            'telegram_date' =>
                                isset($replyMessage['date'])
                                    ? date(
                                        'Y-m-d H:i:s',
                                        $replyMessage['date']
                                    )
                                    : null,
                        ]);

                    Log::info(
                        'Old Telegram signal reconstructed',
                        [
                            'signal_id' => $signal->id,
                            'telegram_message_id' =>
                                $replyToMessageId,
                        ]
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Detect update type
        |--------------------------------------------------------------------------
        */

        $updateType =
            $this->parser->detectUpdateType($text);

        /*
        |--------------------------------------------------------------------------
        | Extract pips
        |--------------------------------------------------------------------------
        */

        $resultPips =
            $this->parser->extractPips($text);

        /*
        |--------------------------------------------------------------------------
        | Save update
        |--------------------------------------------------------------------------
        */

        $update =
            TelegramPrivateSignalUpdate::create([

                'signal_id' =>
                    $signal?->id,

                'channel_id' =>
                    $channelId,

                'telegram_message_id' =>
                    $messageId,

                'reply_to_message_id' =>
                    $replyToMessageId,

                'update_type' =>
                    $updateType,

                'result_pips' =>
                    $resultPips,

                'message' =>
                    $text,

                'raw_payload' =>
                    json_encode(
                        $channelPost,
                        JSON_UNESCAPED_UNICODE
                    ),

                'telegram_date' =>
                    $telegramDate,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Update main signal
        |--------------------------------------------------------------------------
        */

        if ($signal) {

            $this->updateSignalStatus(
                $signal,
                $updateType,
                $resultPips,
                $text
            );
        }

        Log::info(
            'Telegram signal update stored',
            [
                'update_id' => $update->id,
                'signal_id' => $signal?->id,
                'type' => $updateType,
                'pips' => $resultPips,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Signal update stored',
            'signal_id' => $signal?->id,
            'update_id' => $update->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update main signal status
    |--------------------------------------------------------------------------
    */

    private function updateSignalStatus(
        TelegramPrivateSignal $signal,
        string $updateType,
        ?float $resultPips,
        string $text
    ): void {

        switch ($updateType) {

            case 'TP1_HIT':

                $signal->status = 'TP1_HIT';

                break;

            case 'TP2_HIT':

                $signal->status = 'TP2_HIT';

                break;

            case 'TP3_HIT':

                $signal->status = 'TP3_HIT';

                break;

            case 'SL_MOVED':

                /*
                |--------------------------------------------------------------------------
                | If message says SL moved to Entry,
                | update SL to Entry.
                |--------------------------------------------------------------------------
                */

                if (
                    str_contains(
                        strtolower($text),
                        'entry'
                    )
                ) {
                    $signal->stop_loss =
                        $signal->entry;
                }

                $signal->status = 'ACTIVE';

                break;

            case 'SL_HIT':

                $signal->status = 'SL_HIT';

                if ($resultPips !== null) {
                    $signal->result_pips =
                        $resultPips;
                }

                break;

            case 'TRADE_CLOSED':

                $signal->status = 'CLOSED';

                if ($resultPips !== null) {
                    $signal->result_pips =
                        $resultPips;
                }

                break;
        }

        $signal->save();
    }
}
