<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

        // Button tap
        if (isset($update['callback_query'])) {
            $this->handleCallbackQuery($update['callback_query']);
        }

        // Admin typed a message (for edit field value)
        if (isset($update['message']['text'])) {
            $this->handleTextMessage($update['message']);
        }

        return response()->json(['ok' => true]);
    }

    // ─── Callback Query Router ───────────────────────────────────────────────

    private function handleCallbackQuery(array $cb): void
    {
        $userId = $cb['from']['id'];
        $name   = trim(($cb['from']['first_name'] ?? '') . ' ' . ($cb['from']['last_name'] ?? ''));
        $data   = $cb['data'];
        $chatId = (string) $cb['message']['chat']['id'];
        $msgId  = (string) $cb['message']['message_id'];
        $cbId   = $cb['id'];

        if (!$this->telegram->isAdmin($userId)) {
            $this->telegram->answerCallback($cbId, '⛔ Unauthorized. Only admins can use this.', true);
            return;
        }

        $parts  = explode(':', $data);
        $action = $parts[0];
        $id     = (int) ($parts[1] ?? 0);
        $field  = $parts[2] ?? null;

        match ($action) {
            // Signal actions
            'approve_signal'  => $this->approveSignal($id, $userId, $name, $chatId, $msgId, $cbId),
            'reject_signal'   => $this->rejectSignal($id, $userId, $name, $chatId, $msgId, $cbId),
            'edit_signal'     => $this->editSignal($id, $chatId, $msgId, $cbId),
            'edit_field'      => $this->editField($id, $field, $chatId, $cbId),
            'cancel_edit'     => $this->cancelEdit($id, $chatId, $msgId, $cbId),
            'resubmit_signal' => $this->resubmitSignal($id, $chatId, $msgId, $cbId),
            'delete_signal'   => $this->deleteSignal($id, $chatId, $msgId, $cbId),

            // Result actions
            'approve_result'  => $this->approveResult($id, $userId, $name, $chatId, $msgId, $cbId),
            'reject_result'   => $this->rejectResult($id, $userId, $name, $chatId, $msgId, $cbId),
            'resubmit_result' => $this->resubmitResult($id, $chatId, $msgId, $cbId),
            'delete_result'   => $this->deleteResult($id, $chatId, $msgId, $cbId),

            default => $this->telegram->answerCallback($cbId, '⚠️ Unknown action.', true),
        };
    }

    // ─── Signal: Approve ─────────────────────────────────────────────────────

    private function approveSignal(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        $signal = Signal::find($id);

        if (!$signal) {
            $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
            return;
        }

        if ($signal->status === 'posted') {
            $this->telegram->answerCallback($cbId, '⚠️ Already posted!', true);
            return;
        }

        $signal->update([
            'status'      => 'approved',
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);

        $telegramMsgId = $this->telegram->postSignalToChannel($signal);
        $signal->update(['status' => 'posted', 'telegram_message_id' => $telegramMsgId]);

        $this->log('approved_signal', 'signal', $id, $userId, $name);
        $this->telegram->showApprovedSignal($signal, $chatId, $msgId, $name);
        $this->telegram->answerCallback($cbId, '✅ Signal posted to channel!');
    }

    // ─── Signal: Reject ──────────────────────────────────────────────────────

    private function rejectSignal(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        $signal = Signal::find($id);

        if (!$signal) {
            $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
            return;
        }

        $signal->update(['status' => 'rejected']);
        $this->log('rejected_signal', 'signal', $id, $userId, $name);

        // Show rejected status WITH re-submit and delete buttons
        $this->telegram->showRejectedSignal($signal, $chatId, $msgId, $name);
        $this->telegram->answerCallback($cbId, '❌ Signal rejected.');
    }

    // ─── Signal: Edit ────────────────────────────────────────────────────────

    private function editSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $signal = Signal::find($id);

        if (!$signal) {
            $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
            return;
        }

        // Show the edit field menu inline
        $this->telegram->showEditMenu($signal, $chatId, $msgId);
        $this->telegram->answerCallback($cbId, '✏️ Choose a field to edit.');
    }

    private function editField(int $signalId, ?string $field, string $chatId, string $cbId): void
    {
        $signal = Signal::find($signalId);

        if (!$signal || !$field) {
            $this->telegram->answerCallback($cbId, '⚠️ Invalid edit request.', true);
            return;
        }

        // Store in cache: "which signal + field is this admin editing?"
        // Key: chat_id → [signal_id, field, original_msg_id]
        Cache::put("edit_state:{$chatId}", [
            'signal_id' => $signalId,
            'field'     => $field,
        ], now()->addMinutes(5));

        // Ask admin to type the new value
        $this->telegram->askForFieldValue($signal, $field, $chatId);
        $this->telegram->answerCallback($cbId, "✏️ Type the new {$field} value.");
    }

    private function cancelEdit(int $signalId, string $chatId, string $msgId, string $cbId): void
    {
        Cache::forget("edit_state:{$chatId}");

        $signal = Signal::find($signalId);
        if ($signal) {
            // Restore the original approval keyboard
            $this->telegram->showEditMenu($signal, $chatId, $msgId);
        }

        $this->telegram->answerCallback($cbId, '🚫 Edit cancelled.');
    }

    // ─── Signal: Re-submit (after reject) ────────────────────────────────────

    private function resubmitSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $signal = Signal::find($id);

        if (!$signal) {
            $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
            return;
        }

        $signal->update(['status' => 'pending_approval']);

        // Replace the rejected message with fresh preview + buttons
        $this->telegram->editMessageWithApprovalButtons($signal, $chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🔁 Re-submitted for approval!');
    }

    // ─── Signal: Delete ──────────────────────────────────────────────────────

    private function deleteSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $signal = Signal::find($id);

        if ($signal) {
            $signal->delete();
        }

        $this->telegram->deleteMessage($chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🗑️ Signal deleted.');
    }

    // ─── Result: Approve ─────────────────────────────────────────────────────

    private function approveResult(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
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
        $this->telegram->answerCallback($cbId, '✅ Result posted to channel!');
    }

    // ─── Result: Reject ──────────────────────────────────────────────────────

    private function rejectResult(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        $result = SignalResult::find($id);

        if (!$result) {
            $this->telegram->answerCallback($cbId, '⚠️ Result not found.', true);
            return;
        }

        $result->update(['status' => 'rejected']);
        $this->log('rejected_result', 'signal_result', $id, $userId, $name);

        $this->telegram->showRejectedResult($result, $chatId, $msgId, $name);
        $this->telegram->answerCallback($cbId, '❌ Result rejected.');
    }

    // ─── Result: Re-submit ───────────────────────────────────────────────────

    private function resubmitResult(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $result = SignalResult::find($id);

        if (!$result) {
            $this->telegram->answerCallback($cbId, '⚠️ Result not found.', true);
            return;
        }

        $result->update(['status' => 'pending_approval']);
        $this->telegram->editResultWithApprovalButtons($result, $chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🔁 Re-submitted for approval!');
    }

    // ─── Result: Delete ──────────────────────────────────────────────────────

    private function deleteResult(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $result = SignalResult::find($id);
        if ($result) $result->delete();

        $this->telegram->deleteMessage($chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🗑️ Result deleted.');
    }

    // ─── Text Message Handler (Edit field value typed by admin) ──────────────

    private function handleTextMessage(array $message): void
    {
        $chatId = (string) $message['chat']['id'];
        $text   = trim($message['text'] ?? '');
        $userId = $message['from']['id'];

        if (!$this->telegram->isAdmin($userId)) return;

        $cacheKey = "edit_state:{$chatId}";
        $state    = Cache::get($cacheKey);

        if (!$state) return; // Not in edit mode

        Cache::forget($cacheKey);

        $signal = Signal::find($state['signal_id']);
        if (!$signal) return;

        $field = $state['field'];
        $this->applyFieldEdit($signal, $field, $text, $chatId);
    }

    private function applyFieldEdit(Signal $signal, string $field, string $value, string $chatId): void
    {
        $update = [];

        switch ($field) {
            case 'entry':
                // Support range: "1.2800-1.2820" or "1.2800 - 1.2820"
                if (str_contains($value, '-')) {
                    [$min, $max] = array_map('trim', explode('-', $value, 2));
                    $update['entry_min'] = (float) $min;
                    $update['entry_max'] = (float) $max;
                } else {
                    $update['entry_min'] = (float) $value;
                    $update['entry_max'] = null;
                }
                break;

            case 'sl':        $update['sl']        = (float) $value; break;
            case 'tp1':       $update['tp1']        = (float) $value; break;
            case 'tp2':       $update['tp2']        = (float) $value; break;
            case 'tp3':       $update['tp3']        = (float) $value; break;
            case 'direction': $update['direction']  = strtoupper(trim($value)); break;
            case 'pair':      $update['pair']        = strtoupper(trim($value)); break;
            case 'channel':   $update['channel']    = strtolower(trim($value)); break;
        }

        $signal->update($update);

        // Regenerate formatted message text
        $signal->refresh();
        $signal->update([
            'signal_text' => app(\App\Services\MessageFormatterService::class)->formatSignal($signal),
            'status'      => 'pending_approval',
        ]);

        // Send updated preview with approval buttons as a new message
        $this->telegram->sendSignalPreview($signal);

        // Confirm the edit
        $this->telegram->sendMessage([
            'chat_id'    => $chatId,
            'text'       => "✅ *{$field}* updated to `{$value}`\n\nA fresh preview has been sent above for approval.",
            'parse_mode' => 'Markdown',
        ]);
    }

    // ─── Audit Log Helper ────────────────────────────────────────────────────

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
