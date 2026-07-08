<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MT5SignalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'signal_id' => $this->id,

            'telegram_post_id' => $this->post_id,

            'signal_date' => optional($this->signal_date)->format('Y-m-d'),

            'pair' => $this->pair,

            'symbol' => $this->pair,

            'order_type' => $this->order_type == 0
                ? 'BUY'
                : 'SELL',

            'entry_price' => (double)$this->entry_price,

            'stop_loss' => (double)$this->stop_loss,

            'take_profit' => json_decode($this->take_profit, true),

            'signal_url' => $this->live_btn_url,

            'created_at' => $this->created_at?->toDateTimeString(),

        ];
    }
}
