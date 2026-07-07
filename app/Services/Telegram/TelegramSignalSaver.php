<?php

namespace App\Services\Telegram;

use App\Models\ForexUpdate;
use Carbon\Carbon;

class TelegramSignalSaver
{
    /**
     * Save Signal
     */
    public static function save(
        array $signal,
        ?array $result,
        string $postId,
        int $msgId,
        ?string $datetime
    ): ForexUpdate {

        $liveBtnUrl = "https://t.me/{$postId}";

        $resultId = null;
        $resultDate = null;

        /*
        |--------------------------------------------------------------------------
        | If this telegram message contains HIT/SL result,
        | find original signal.
        |--------------------------------------------------------------------------
        */

        if ($result) {

            $oldSignal = self::findOldSignal(
                $signal,
                $liveBtnUrl
            );

            if ($oldSignal) {

                $resultId = $oldSignal->id;

                $resultDate = Carbon::parse($datetime)
                    ->format('Y-m-d');

                // keep same telegram url
                $liveBtnUrl = $oldSignal->live_btn_url;
            }
        }

        return ForexUpdate::updateOrCreate(

            [
                'live_btn_url' => $liveBtnUrl
            ],

            [

                'signal_date' => $datetime
                    ? Carbon::parse($datetime)->format('Y-m-d')
                    : null,

                'pair' => $signal['pair'],

                'order_type' => $signal['direction'] == 'SELL'
                    ? 1
                    : 0,

                'entry_price' => $signal['entry_price'],

                'stop_loss' => $signal['stop_loss'],

                'take_profit' => json_encode(
                    $signal['take_profit']
                ),

                'profit' => $result['profit'] ?? null,

                'status' => 1,

                'sort_order' => 0,

                'post_id' => $msgId,

                'result_id' => $resultId,

                'result_date' => $resultDate,

            ]

        );
    }

    /**
     * Find Original Signal
     */
    protected static function findOldSignal(
        array $signal,
        string $liveBtnUrl
    ): ?ForexUpdate {

        $query = ForexUpdate::query()

            ->where('live_btn_url', '!=', $liveBtnUrl)

            ->where('pair', $signal['pair'])

            ->where(
                'order_type',
                $signal['direction'] == 'SELL'
                    ? 1
                    : 0
            )

            ->where('status', 1);

        /*
        |--------------------------------------------------------------------------
        | Entry
        |--------------------------------------------------------------------------
        */

        if (!empty($signal['entry_price'])) {

            $query->where(
                'entry_price',
                $signal['entry_price']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Stop Loss
        |--------------------------------------------------------------------------
        */

        if (!empty($signal['stop_loss'])) {

            $query->where(
                'stop_loss',
                $signal['stop_loss']
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Take Profit
        |--------------------------------------------------------------------------
        */

        if (!empty($signal['take_profit'])) {

            foreach ($signal['take_profit'] as $tp) {

                $query->whereJsonContains(
                    'take_profit',
                    $tp
                );

            }

        }

        return $query
            ->latest('id')
            ->first();
    }

}
