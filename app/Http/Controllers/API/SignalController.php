<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSignalRequest;
use App\Models\Signal;
use App\Services\MessageFormatterService;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;

class SignalController extends Controller
{
    public function __construct(
        private MessageFormatterService $formatter,
        private TelegramService $telegram
    ) {}

    public function store(StoreSignalRequest $request): JsonResponse
    {
        $signal = Signal::create([
            ...$request->validated(),
            'status' => 'draft',
        ]);

        // Auto-format message text
        $signal->update(['signal_text' => $this->formatter->formatSignal($signal)]);

        return response()->json(['data' => $signal, 'message' => 'Signal created.'], 201);
    }

    /** Submit to approval group */
    public function submit(Signal $signal): JsonResponse
    {
        $signal->update(['status' => 'pending_approval']);
        $this->telegram->sendSignalPreview($signal);

        return response()->json(['message' => 'Signal sent to approval desk.']);
    }

    public function index(): JsonResponse
    {
        return response()->json(Signal::latest()->paginate(20));
    }

    public function show(Signal $signal): JsonResponse
    {
        return response()->json($signal->load('results'));
    }
}
