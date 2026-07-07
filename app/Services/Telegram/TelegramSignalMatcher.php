<?php

namespace App\Services\Telegram;

use App\Models\ForexUpdate;

class TelegramSignalMatcher
{
    /**
     * Find the best matching signal.
     */
    public static function match(array $signal, string $liveBtnUrl): ?ForexUpdate
    {
        $query = ForexUpdate::query()

            ->where('live_btn_url', '!=', $liveBtnUrl)

            ->where('status', 1)

            ->where('pair', $signal['pair'])

            ->where(
                'order_type',
                $signal['direction'] == 'SELL' ? 1 : 0
            )

            ->orderByDesc('signal_date')
            ->orderByDesc('id');

        $signals = $query->get();

        if ($signals->isEmpty()) {
            return null;
        }

        $best = null;
        $score = -1;

        foreach ($signals as $row) {

            $currentScore = self::calculateScore(
                $signal,
                $row
            );

            if ($currentScore > $score) {

                $score = $currentScore;

                $best = $row;
            }
        }

        return $best;
    }

    /**
     * Score Matching
     */
    protected static function calculateScore(
        array $signal,
        ForexUpdate $row
    ): int {

        $score = 0;

        /*
        |--------------------------------------------------------------------------
        | Entry
        |--------------------------------------------------------------------------
        */

        if (
            !empty($signal['entry_price']) &&
            $signal['entry_price'] == $row->entry_price
        ) {
            $score += 40;
        }

        /*
        |--------------------------------------------------------------------------
        | Stop Loss
        |--------------------------------------------------------------------------
        */

        if (
            !empty($signal['stop_loss']) &&
            $signal['stop_loss'] == $row->stop_loss
        ) {
            $score += 30;
        }

        /*
        |--------------------------------------------------------------------------
        | Take Profit
        |--------------------------------------------------------------------------
        */

        $dbTP = json_decode($row->take_profit, true) ?? [];

        foreach ($signal['take_profit'] as $tp) {

            if (in_array($tp, $dbTP)) {

                $score += 10;

            }

        }

        return $score;
    }
}
