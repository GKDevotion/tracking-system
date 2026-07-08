<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MT5SignalCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [

            'success' => true,

            'server_time' => now()->toDateTimeString(),

            'count' => $this->collection->count(),

            'signals' => MT5SignalResource::collection($this->collection),

        ];
    }
}
