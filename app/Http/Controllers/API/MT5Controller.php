<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ForexUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MT5Controller extends Controller
{
    /**
     * Return pending signals to MT5
     *
     * GET /api/mt5/signals
     */
    public function signals(Request $request)
    {
        DB::beginTransaction();

        try {

            $signals = ForexUpdate::where('status', 1)
                ->where('mt5_status', 0)
                ->orderBy('id')
                ->limit(20)
                ->lockForUpdate()
                ->get();

            foreach ($signals as $signal) {

                $signal->update([
                    'mt5_status' => 1, // Sent
                    'sent_at'    => now(),
                ]);

            }

            DB::commit();

            $response = $signals->map(function ($signal) {

                return [

                    'signal_id' => $signal->id,

                    'pair' => $signal->pair,

                    'order_type' => $signal->order_type == 0 ? 'BUY' : 'SELL',

                    'entry_price' => (double)$signal->entry_price,

                    'stop_loss' => (double)$signal->stop_loss,

                    'take_profit' => json_decode($signal->take_profit, true),

                    'post_id' => $signal->post_id,

                    'signal_date' => $signal->signal_date,

                ];

            });

            return response()->json([
                'success' => true,
                'count' => $response->count(),
                'data' => $response
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('MT5 Signal API', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    /**
     * MT5 confirms trade opened
     *
     * POST /api/mt5/executed
     */
    public function executed(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'signal_id' => 'required|integer|exists:free_signals_updates,id',

            'ticket' => 'required',

            'price' => 'required|numeric',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);

        }

        DB::beginTransaction();

        try {

            $signal = ForexUpdate::findOrFail($request->signal_id);

            $signal->update([

                'ticket' => $request->ticket,

                'executed_price' => $request->price,

                'executed_at' => now(),

                'mt5_status' => 2,

                'mt5_response' => json_encode($request->all()),

            ]);

            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Trade executed successfully.'

            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('MT5 Executed', [
                'message' => $e->getMessage()
            ]);

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);

        }
    }

    /**
     * MT5 confirms trade closed
     *
     * POST /api/mt5/closed
     */
    public function closed(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'signal_id' => 'required|integer|exists:free_signals_updates,id',

            'ticket' => 'required',

            'profit' => 'nullable|numeric',

            'reason' => 'nullable|string',

        ]);

        if ($validator->fails()) {

            return response()->json([

                'success' => false,

                'errors' => $validator->errors()

            ], 422);

        }

        DB::beginTransaction();

        try {

            $signal = ForexUpdate::findOrFail($request->signal_id);

            $response = json_decode($signal->mt5_response, true);

            $response['close'] = $request->all();

            $signal->update([

                'profit' => $request->profit,

                'closed_at' => now(),

                'mt5_status' => 3,

                'mt5_response' => json_encode($response),

            ]);

            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Trade closed successfully.'

            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('MT5 Closed', [
                'message' => $e->getMessage()
            ]);

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);

        }

    }

    /**
     * Reset Sent Signals
     * Useful when MT5 disconnects.
     *
     * POST /api/mt5/reset
     */
    public function reset()
    {

        ForexUpdate::where('mt5_status', 1)

            ->update([

                'mt5_status' => 0,

                'sent_at' => null

            ]);

        return response()->json([

            'success' => true,

            'message' => 'Pending queue restored.'

        ]);

    }
}
