<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Signal;
use App\Models\SignalResult;
use App\Models\AuditLog;
use App\Services\TelegramService;
use App\Services\MessageFormatterService;

class TelegramWebhookController extends Controller
{
    public function __construct(
        private TelegramService     $telegram,
        private MessageFormatterService $formatter
    ) {}

    // ─── Entry Point ─────────────────────────────────────────────────────────

    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        $update = $request->json()->all();

        Log::channel('telegram')->info('📥 WEBHOOK RECEIVED', [
            'update' => $update,
        ]);

        if (isset($update['callback_query'])) {
            Log::channel('telegram')->info('🔘 CALLBACK QUERY DETECTED', [
                'callback_data' => $update['callback_query']['data'] ?? null,
                'from_user'     => $update['callback_query']['from']['id'] ?? null,
                'message_id'    => $update['callback_query']['message']['message_id'] ?? null,
            ]);
            $this->handleCallbackQuery($update['callback_query']);
        }

        if (isset($update['message']['text'])) {
            Log::channel('telegram')->info('💬 TEXT MESSAGE DETECTED', [
                'from'    => $update['message']['from']['id'] ?? null,
                'chat_id' => $update['message']['chat']['id'] ?? null,
                'text'    => $update['message']['text'] ?? null,
            ]);
            $this->handleTextMessage($update['message']);
        }

        return response()->json(['ok' => true]);
    }

    // ─── Callback Query Router ────────────────────────────────────────────────

    private function handleCallbackQuery(array $cb): void
    {
        $userId = $cb['from']['id'];
        $name   = trim(($cb['from']['first_name'] ?? '') . ' ' . ($cb['from']['last_name'] ?? ''));
        $data   = $cb['data'];
        $chatId = (string) $cb['message']['chat']['id'];
        $msgId  = (string) $cb['message']['message_id'];
        $cbId   = $cb['id'];

        Log::channel('telegram')->info('🎯 CALLBACK PARSED', [
            'user_id' => $userId,
            'name'    => $name,
            'data'    => $data,
            'chat_id' => $chatId,
            'msg_id'  => $msgId,
        ]);

        // Admin check
        if (!$this->telegram->isAdmin($userId)) {
            Log::channel('telegram')->warning('⛔ UNAUTHORIZED USER', ['user_id' => $userId]);
            $this->telegram->answerCallback($cbId, '⛔ Unauthorized.', true);
            return;
        }

        $parts  = explode(':', $data);
        $action = $parts[0] ?? '';
        $id     = isset($parts[1]) ? (int) $parts[1] : 0;
        $field  = $parts[2] ?? null;

        Log::channel('telegram')->info('🔀 ROUTING ACTION', [
            'action' => $action,
            'id'     => $id,
            'field'  => $field,
        ]);

        match ($action) {
            'approve_signal'  => $this->approveSignal($id, $userId, $name, $chatId, $msgId, $cbId),
            'reject_signal'   => $this->rejectSignal($id, $userId, $name, $chatId, $msgId, $cbId),
            'edit_signal'     => $this->editSignal($id, $chatId, $msgId, $cbId),
            'edit_field'      => $this->editField($id, $field, $chatId, $msgId, $cbId),
            'cancel_edit'     => $this->cancelEdit($id, $userId, $chatId, $msgId, $cbId),
            'resubmit_signal' => $this->resubmitSignal($id, $chatId, $msgId, $cbId),
            'delete_signal'   => $this->deleteSignal($id, $chatId, $msgId, $cbId),
            'approve_result'  => $this->approveResult($id, $userId, $name, $chatId, $msgId, $cbId),
            'reject_result'   => $this->rejectResult($id, $userId, $name, $chatId, $msgId, $cbId),
            'resubmit_result' => $this->resubmitResult($id, $chatId, $msgId, $cbId),
            'delete_result'   => $this->deleteResult($id, $chatId, $msgId, $cbId),
            default           => $this->unknownAction($action, $cbId),
        };
    }

    // ─── Unknown Action ───────────────────────────────────────────────────────

    private function unknownAction(string $action, string $cbId): void
    {
        Log::channel('telegram')->error('❓ UNKNOWN ACTION', ['action' => $action]);
        $this->telegram->answerCallback($cbId, "⚠️ Unknown action: {$action}", true);
    }

    // ─── Signal: Approve ──────────────────────────────────────────────────────

    private function approveSignal(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✅ APPROVE SIGNAL START', ['signal_id' => $id]);

        try {
            $signal = Signal::find($id);

            if (!$signal) {
                Log::channel('telegram')->error('❌ SIGNAL NOT FOUND', ['signal_id' => $id]);
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }

            if ($signal->status === 'posted') {
                Log::channel('telegram')->warning('⚠️ ALREADY POSTED', ['signal_id' => $id]);
                $this->telegram->answerCallback($cbId, '⚠️ Already posted!', true);
                return;
            }

            $signal->update(['status' => 'approved', 'approved_by' => $userId, 'approved_at' => now()]);
            Log::channel('telegram')->info('✅ SIGNAL STATUS → approved', ['signal_id' => $id]);

            $telegramMsgId = $this->telegram->postSignalToChannel($signal);
            $signal->update(['status' => 'posted', 'telegram_message_id' => $telegramMsgId]);
            Log::channel('telegram')->info('📤 SIGNAL POSTED TO CHANNEL', ['telegram_msg_id' => $telegramMsgId]);

            $this->log('approved_signal', 'signal', $id, $userId, $name);
            $this->telegram->showApprovedSignal($signal, $chatId, $msgId, $name);
            $this->telegram->answerCallback($cbId, '✅ Signal posted to channel!');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 APPROVE SIGNAL ERROR', [
                'signal_id' => $id,
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);
            $this->telegram->answerCallback($cbId, '💥 Server error. Check logs.', true);
        }
    }

    // ─── Signal: Reject ───────────────────────────────────────────────────────

    private function rejectSignal(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('❌ REJECT SIGNAL START', ['signal_id' => $id]);

        try {
            $signal = Signal::find($id);

            if (!$signal) {
                Log::channel('telegram')->error('❌ SIGNAL NOT FOUND', ['signal_id' => $id]);
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }

            $signal->update(['status' => 'rejected']);
            Log::channel('telegram')->info('✅ SIGNAL STATUS → rejected', ['signal_id' => $id]);

            $this->log('rejected_signal', 'signal', $id, $userId, $name);
            $this->telegram->showRejectedSignal($signal, $chatId, $msgId, $name);
            $this->telegram->answerCallback($cbId, '❌ Signal rejected.');
            Log::channel('telegram')->info('✅ REJECT SIGNAL COMPLETE', ['signal_id' => $id]);

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 REJECT SIGNAL ERROR', [
                'signal_id' => $id,
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);
            $this->telegram->answerCallback($cbId, '💥 Server error. Check logs.', true);
        }
    }

    // ─── Signal: Edit — Step 1 (show field selector) ─────────────────────────

    private function editSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✏️ EDIT SIGNAL START', [
            'signal_id' => $id,
            'chat_id'   => $chatId,
            'msg_id'    => $msgId,
        ]);

        try {
            $signal = Signal::find($id);

            if (!$signal) {
                Log::channel('telegram')->error('❌ SIGNAL NOT FOUND FOR EDIT', ['signal_id' => $id]);
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }

            Log::channel('telegram')->info('✅ SIGNAL FOUND FOR EDIT', [
                'pair'      => $signal->pair,
                'direction' => $signal->direction,
                'status'    => $signal->status,
            ]);

            // Store msg_id in cache so we can restore the preview after editing
            Cache::put("edit_origin:{$chatId}:{$id}", $msgId, now()->addMinutes(10));
            Log::channel('telegram')->info('💾 EDIT ORIGIN CACHED', [
                'key'    => "edit_origin:{$chatId}:{$id}",
                'msg_id' => $msgId,
            ]);

            $result = $this->telegram->showEditMenu($signal, $chatId, $msgId);
            Log::channel('telegram')->info('📤 EDIT MENU SENT TO TELEGRAM', ['api_result' => $result]);

            $this->telegram->answerCallback($cbId, '✏️ Choose a field to edit.');
            Log::channel('telegram')->info('✅ EDIT SIGNAL STEP 1 COMPLETE');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 EDIT SIGNAL ERROR', [
                'signal_id' => $id,
                'error'     => $e->getMessage(),
                'line'      => $e->getLine(),
                'file'      => $e->getFile(),
                'trace'     => $e->getTraceAsString(),
            ]);
            $this->telegram->answerCallback($cbId, '💥 Edit failed. Check logs.', true);
        }
    }

    // ─── Signal: Edit — Step 2 (field selected, ask for value) ───────────────

    private function editField(int $signalId, ?string $field, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✏️ EDIT FIELD SELECTED', [
            'signal_id' => $signalId,
            'field'     => $field,
            'chat_id'   => $chatId,
        ]);

        try {
            if (!$field) {
                Log::channel('telegram')->error('❌ NO FIELD PROVIDED');
                $this->telegram->answerCallback($cbId, '⚠️ No field specified.', true);
                return;
            }

            $signal = Signal::find($signalId);

            if (!$signal) {
                Log::channel('telegram')->error('❌ SIGNAL NOT FOUND', ['signal_id' => $signalId]);
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }

            // Save edit state in cache — expires in 5 min
            $cacheKey = "edit_state:{$chatId}";
            $cacheData = [
                'signal_id'      => $signalId,
                'field'          => $field,
                'origin_msg_id'  => $msgId,
            ];
            Cache::put($cacheKey, $cacheData, now()->addMinutes(5));

            Log::channel('telegram')->info('💾 EDIT STATE CACHED', [
                'key'  => $cacheKey,
                'data' => $cacheData,
            ]);

            // Send a NEW message asking for the value (don't edit the menu)
            $result = $this->telegram->askForFieldValue($signal, $field, $chatId);
            Log::channel('telegram')->info('📤 ASK FOR VALUE SENT', ['api_result' => $result]);

            $this->telegram->answerCallback($cbId, "✏️ Type the new {$field} value now.");
            Log::channel('telegram')->info('✅ EDIT FIELD STEP 2 COMPLETE');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 EDIT FIELD ERROR', [
                'signal_id' => $signalId,
                'field'     => $field,
                'error'     => $e->getMessage(),
                'line'      => $e->getLine(),
                'file'      => $e->getFile(),
                'trace'     => $e->getTraceAsString(),
            ]);
            $this->telegram->answerCallback($cbId, '💥 Field select failed. Check logs.', true);
        }
    }

    // ─── Signal: Edit — Step 3 (admin typed value) ────────────────────────────

    private function handleTextMessage(array $message): void
    {
        $chatId = (string) $message['chat']['id'];
        $text   = trim($message['text'] ?? '');
        $userId = $message['from']['id'];
        $name   = trim(($message['from']['first_name'] ?? '') . ' ' . ($message['from']['last_name'] ?? ''));

        Log::channel('telegram')->info('💬 TEXT MESSAGE HANDLER', [
            'chat_id' => $chatId,
            'user_id' => $userId,
            'text'    => $text,
        ]);

        if (!$this->telegram->isAdmin($userId)) {
            Log::channel('telegram')->warning('⛔ NON-ADMIN TEXT IGNORED', ['user_id' => $userId]);
            return;
        }

        $cacheKey = "edit_state:{$chatId}";
        $state    = Cache::get($cacheKey);

        Log::channel('telegram')->info('🔍 EDIT STATE FROM CACHE', [
            'key'   => $cacheKey,
            'state' => $state,
        ]);

        if (!$state) {
            Log::channel('telegram')->info('ℹ️ NO EDIT STATE FOUND — ignoring text message');
            return;
        }

        // Clear cache immediately so double-sends don't re-trigger
        Cache::forget($cacheKey);
        Log::channel('telegram')->info('🗑️ EDIT STATE CACHE CLEARED');

        $signal = Signal::find($state['signal_id']);

        if (!$signal) {
            Log::channel('telegram')->error('❌ SIGNAL NOT FOUND FOR TEXT EDIT', ['signal_id' => $state['signal_id']]);
            return;
        }

        $field         = $state['field'];
        $originMsgId   = $state['origin_msg_id'];

        Log::channel('telegram')->info('✏️ APPLYING FIELD EDIT', [
            'signal_id' => $signal->id,
            'field'     => $field,
            'new_value' => $text,
        ]);

        try {
            $this->applyFieldEdit($signal, $field, $text, $chatId, $originMsgId);
            Log::channel('telegram')->info('✅ FIELD EDIT APPLIED SUCCESSFULLY');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 APPLY FIELD EDIT ERROR', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->telegram->sendMessage([
                'chat_id'    => $chatId,
                'text'       => "💥 Failed to apply edit.\n\nError: `{$e->getMessage()}`",
                'parse_mode' => 'Markdown',
            ]);
        }
    }

    private function applyFieldEdit(Signal $signal, string $field, string $value, string $chatId, string $originMsgId): void
    {
        $update = [];

        switch ($field) {
            case 'entry':
                // Support: "1.2800-1.2820" or "1.2800 - 1.2820" or "1.2800"
                $normalized = preg_replace('/\s*[-–]\s*/', '-', $value);
                if (str_contains($normalized, '-')) {
                    [$min, $max]         = explode('-', $normalized, 2);
                    $update['entry_min'] = (float) trim($min);
                    $update['entry_max'] = (float) trim($max);
                } else {
                    $update['entry_min'] = (float) $value;
                    $update['entry_max'] = null;
                }
                break;

            case 'sl':        $update['sl']        = (float) $value;          break;
            case 'tp1':       $update['tp1']        = (float) $value;          break;
            case 'tp2':       $update['tp2']        = (float) $value;          break;
            case 'tp3':       $update['tp3']        = (float) $value;          break;
            case 'direction': $update['direction']  = strtoupper(trim($value)); break;
            case 'pair':      $update['pair']        = strtoupper(trim($value)); break;
            case 'channel':   $update['channel']    = strtolower(trim($value)); break;

            default:
                Log::channel('telegram')->error('❌ UNKNOWN FIELD IN APPLY EDIT', ['field' => $field]);
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text'    => "⚠️ Unknown field: `{$field}`",
                    'parse_mode' => 'Markdown',
                ]);
                return;
        }

        $signal->update($update);
        $signal->refresh();

        Log::channel('telegram')->info('✅ DB UPDATED', ['updated_fields' => $update]);

        // Regenerate formatted signal text
        $newText = $this->formatter->formatSignal($signal);
        $signal->update([
            'signal_text' => $newText,
            'status'      => 'pending_approval',
        ]);

        Log::channel('telegram')->info('✅ SIGNAL TEXT REGENERATED');

        // Step 1: Send confirmation message
        $this->telegram->sendMessage([
            'chat_id'    => $chatId,
            'text'       => "✅ *{$field}* updated to `{$value}`",
            'parse_mode' => 'Markdown',
        ]);

        // Step 2: Edit the ORIGINAL preview message back to approval mode with updated content
        $this->telegram->editMessageWithApprovalButtons($signal, $chatId, $originMsgId);

        Log::channel('telegram')->info('✅ ORIGINAL PREVIEW MESSAGE RESTORED WITH NEW VALUES', [
            'origin_msg_id' => $originMsgId,
        ]);
    }

    // ─── Signal: Cancel Edit ──────────────────────────────────────────────────

    private function cancelEdit(int $signalId, int $userId, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('🚫 CANCEL EDIT', ['signal_id' => $signalId]);

        Cache::forget("edit_state:{$chatId}");

        $signal = Signal::find($signalId);
        if ($signal) {
            $this->telegram->editMessageWithApprovalButtons($signal, $chatId, $msgId);
        }

        $this->telegram->answerCallback($cbId, '🚫 Edit cancelled. Back to approval.');
    }

    // ─── Signal: Re-submit ────────────────────────────────────────────────────

    private function resubmitSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('🔁 RESUBMIT SIGNAL', ['signal_id' => $id]);

        try {
            $signal = Signal::find($id);
            if (!$signal) {
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }

            $signal->update(['status' => 'pending_approval']);
            $this->telegram->editMessageWithApprovalButtons($signal, $chatId, $msgId);
            $this->telegram->answerCallback($cbId, '🔁 Re-submitted for approval!');
            Log::channel('telegram')->info('✅ RESUBMIT COMPLETE');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 RESUBMIT ERROR', ['error' => $e->getMessage()]);
            $this->telegram->answerCallback($cbId, '💥 Re-submit failed.', true);
        }
    }

    // ─── Signal: Delete ───────────────────────────────────────────────────────

    private function deleteSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('🗑️ DELETE SIGNAL', ['signal_id' => $id]);

        $signal = Signal::find($id);
        if ($signal) $signal->delete();

        $this->telegram->deleteMessage($chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🗑️ Signal deleted.');
        Log::channel('telegram')->info('✅ SIGNAL DELETED');
    }

    // ─── Result: Approve ─────────────────────────────────────────────────────

    private function approveResult(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✅ APPROVE RESULT START', ['result_id' => $id]);

        try {
            $result = SignalResult::find($id);
            if (!$result) {
                $this->telegram->answerCallback($cbId, '⚠️ Result not found.', true);
                return;
            }

            $result->update(['status' => 'approved', 'approved_by' => $userId, 'approved_at' => now()]);
            $telegramMsgId = $this->telegram->postResultToChannel($result);
            $result->update(['status' => 'posted', 'telegram_message_id' => $telegramMsgId]);

            $this->log('approved_result', 'signal_result', $id, $userId, $name);
            $this->telegram->showApprovedResult($result, $chatId, $msgId, $name);
            $this->telegram->answerCallback($cbId, '✅ Result posted!');
            Log::channel('telegram')->info('✅ RESULT APPROVED AND POSTED');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 APPROVE RESULT ERROR', ['error' => $e->getMessage()]);
            $this->telegram->answerCallback($cbId, '💥 Server error.', true);
        }
    }

    // ─── Result: Reject ───────────────────────────────────────────────────────

    private function rejectResult(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('❌ REJECT RESULT START', ['result_id' => $id]);

        try {
            $result = SignalResult::find($id);
            if (!$result) {
                $this->telegram->answerCallback($cbId, '⚠️ Result not found.', true);
                return;
            }

            $result->update(['status' => 'rejected']);
            $this->log('rejected_result', 'signal_result', $id, $userId, $name);
            $this->telegram->showRejectedResult($result, $chatId, $msgId, $name);
            $this->telegram->answerCallback($cbId, '❌ Result rejected.');
            Log::channel('telegram')->info('✅ RESULT REJECTED');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 REJECT RESULT ERROR', ['error' => $e->getMessage()]);
            $this->telegram->answerCallback($cbId, '💥 Server error.', true);
        }
    }

    // ─── Result: Re-submit ────────────────────────────────────────────────────

    private function resubmitResult(int $id, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('🔁 RESUBMIT RESULT', ['result_id' => $id]);

        $result = SignalResult::find($id);
        if (!$result) {
            $this->telegram->answerCallback($cbId, '⚠️ Result not found.', true);
            return;
        }

        $result->update(['status' => 'pending_approval']);
        $this->telegram->editResultWithApprovalButtons($result, $chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🔁 Re-submitted!');
    }

    // ─── Result: Delete ───────────────────────────────────────────────────────

    private function deleteResult(int $id, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('🗑️ DELETE RESULT', ['result_id' => $id]);

        $result = SignalResult::find($id);
        if ($result) $result->delete();

        $this->telegram->deleteMessage($chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🗑️ Result deleted.');
    }

    // ─── Audit Log Helper ─────────────────────────────────────────────────────

    private function log(string $action, string $type, int $id, int $userId, string $name): void
    {
        AuditLog::create([
            'action'            => $action,
            'entity_type'       => $type,
            'entity_id'         => $id,
            'performed_by'      => $userId,
            'performed_by_name' => $name,
        ]);
    }
}
