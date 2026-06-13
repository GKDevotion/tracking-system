<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signal;
use App\Models\SignalResult;
use App\Services\MessageFormatterService;
use App\Services\PipCalculatorService;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SignalResultController extends Controller
{
    public function __construct(
        private MessageFormatterService $formatter,
        private PipCalculatorService $pips,
        private TelegramService $telegram
    ) {}

    public function store(Request $request, Signal $signal): JsonResponse
    {
        $request->validate([
            'result_type' => 'required|in:T1,T2,T3,SL,BE',
            'target_price'=> 'nullable|numeric',
        ]);

        $type   = $request->result_type;
        $target = match ($type) {
            'T1' => $signal->tp1,
            'T2' => $signal->tp2,
            'T3' => $signal->tp3,
            'SL' => $signal->sl,
            'BE' => null,
            default => $request->target_price,
        };

        $pipsValue = $this->pips->calculate(
            $signal->pair,
            $signal->direction,
            $signal->entry_min,
            $signal->entry_max,
            $target,
            $type
        );

        $result = $signal->results()->create([
            'result_type' => $type,
            'pips_points' => $pipsValue,
            'status'      => 'draft',
            'result_text' => '',
        ]);

        $result->update(['result_text' => $this->formatter->formatResult($result)]);

        return response()->json(['data' => $result, 'message' => 'Result created.'], 201);
    }

    public function submit(SignalResult $result): JsonResponse
    {
        $result->update(['status' => 'pending_approval']);
        $this->telegram->sendResultPreview($result);

        return response()->json(['message' => 'Result sent to approval desk.']);
    }
}
