<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Signal;
use App\Models\SignalResult;
use App\Models\AuditLog;
use App\Services\TelegramHttpService;
use App\Services\MessageFormatterService;

class TelegramWebhookController extends Controller
{
    public function __construct(
        private TelegramHttpService     $telegram,
        private MessageFormatterService $formatter
    ) {}

    // ─── Entry Point ──────────────────────────────────────────────────────────

    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        $update = $request->json()->all();

        Log::channel('telegram')->info('📥 WEBHOOK', ['update' => $update]);

        if (isset($update['callback_query'])) {
            $this->handleCallbackQuery($update['callback_query']);
        }

        if (isset($update['message']['text'])) {
            $this->handleTextMessage($update['message']);
        }

        return response()->json(['ok' => true]);
    }

    // ─── Callback Router ──────────────────────────────────────────────────────

    private function handleCallbackQuery(array $cb): void
    {
        $userId = $cb['from']['id'];
        $name   = trim(($cb['from']['first_name'] ?? '') . ' ' . ($cb['from']['last_name'] ?? ''));
        $data   = $cb['data'];
        $chatId = (string) $cb['message']['chat']['id'];
        $msgId  = (string) $cb['message']['message_id'];
        $cbId   = $cb['id'];

        Log::channel('telegram')->info('🎯 CALLBACK', [
            'user'    => "{$userId} ({$name})",
            'data'    => $data,
            'msg_id'  => $msgId,
        ]);

        if (!$this->telegram->isAdmin($userId)) {
            Log::channel('telegram')->warning('⛔ UNAUTHORIZED', ['user_id' => $userId]);
            $this->telegram->answerCallback($cbId, '⛔ Unauthorized.', true);
            return;
        }

        $parts  = explode(':', $data);
        $action = $parts[0] ?? '';
        $id     = (int) ($parts[1] ?? 0);
        $field  = $parts[2] ?? null;

        Log::channel('telegram')->info('🔀 ACTION', ['action' => $action, 'id' => $id, 'field' => $field]);

        match ($action) {
            'approve_signal'   => $this->approveSignal($id, $userId, $name, $chatId, $msgId, $cbId),
            'approve_from_edit'=> $this->approveFromEdit($id, $userId, $name, $chatId, $msgId, $cbId),
            'reject_signal'    => $this->rejectSignal($id, $userId, $name, $chatId, $msgId, $cbId),
            'edit_signal'      => $this->editSignal($id, $chatId, $msgId, $cbId),
            'edit_field'       => $this->editField($id, $field, $chatId, $msgId, $cbId),
            'cancel_edit'      => $this->cancelEdit($id, $chatId, $msgId, $cbId),
            'resubmit_signal'  => $this->resubmitSignal($id, $chatId, $msgId, $cbId),
            'delete_signal'    => $this->deleteSignal($id, $chatId, $msgId, $cbId),
            'approve_result'   => $this->approveResult($id, $userId, $name, $chatId, $msgId, $cbId),
            'reject_result'    => $this->rejectResult($id, $userId, $name, $chatId, $msgId, $cbId),
            'resubmit_result'  => $this->resubmitResult($id, $chatId, $msgId, $cbId),
            'delete_result'    => $this->deleteResult($id, $chatId, $msgId, $cbId),
            default            => $this->unknownAction($action, $cbId),
        };
    }

    // ─── Approve Signal (direct — no edit flow) ───────────────────────────────

    private function approveSignal(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✅ APPROVE SIGNAL (direct)', ['id' => $id]);

        try {
            $signal = Signal::find($id);
            if (!$signal) {
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }
            if ($signal->status === 'posted') {
                $this->telegram->answerCallback($cbId, '⚠️ Already posted!', true);
                return;
            }

            $signal->update(['status' => 'approved', 'approved_by' => $userId, 'approved_at' => now()]);
            $channelMsgId = $this->telegram->postSignalToChannel($signal);
            $signal->update(['status' => 'posted', 'telegram_message_id' => $channelMsgId]);

            $this->log('approved_signal', 'signal', $id, $userId, $name);

            // Just edit the existing preview — no deletions needed
            $this->telegram->showApprovedSignal($signal, $chatId, $msgId, $name);
            $this->telegram->answerCallback($cbId, '✅ Signal posted!');

            Log::channel('telegram')->info('✅ APPROVED (direct) COMPLETE', ['id' => $id]);

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 APPROVE SIGNAL ERROR', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->telegram->answerCallback($cbId, '💥 Server error. Check logs.', true);
        }
    }

    // ─── Approve From Edit (Done button inside edit menu) ─────────────────────

    /**
     * This is the KEY handler — called when admin taps "Done — Approve & Post"
     * while inside the edit menu.
     *
     * Flow:
     * 1. Delete edit menu message (msgId)
     * 2. Delete all prompt messages stored in cache
     * 3. Post to channel
     * 4. Send fresh clean approved message
     */
    private function approveFromEdit(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✅ APPROVE FROM EDIT START', ['signal_id' => $id, 'edit_menu_msg_id' => $msgId]);

        try {
            $signal = Signal::find($id);
            if (!$signal) {
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }
            if ($signal->status === 'posted') {
                $this->telegram->answerCallback($cbId, '⚠️ Already posted!', true);
                return;
            }

            // Retrieve all prompt message IDs stored during edit session
            $promptMsgIds = Cache::get("edit_prompts:{$chatId}:{$id}", []);
            Log::channel('telegram')->info('📋 PROMPT MSG IDS TO DELETE', ['ids' => $promptMsgIds]);

            // Clear all edit-related cache
            Cache::forget("edit_state:{$chatId}");
            Cache::forget("edit_prompts:{$chatId}:{$id}");
            Cache::forget("edit_origin:{$chatId}:{$id}");

            // Update DB
            $signal->update(['status' => 'approved', 'approved_by' => $userId, 'approved_at' => now()]);

            // Delete edit menu + all prompts, post to channel, send clean message
            $this->telegram->postCleanApproved($signal, $chatId, $msgId, $promptMsgIds, $name);

            $channelMsgId = $signal->telegram_message_id; // already set inside postCleanApproved
            $signal->update(['status' => 'posted']);

            $this->log('approved_signal', 'signal', $id, $userId, $name);
            $this->telegram->answerCallback($cbId, '✅ Signal posted!');

            Log::channel('telegram')->info('✅ APPROVE FROM EDIT COMPLETE', ['signal_id' => $id]);

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 APPROVE FROM EDIT ERROR', [
                'error' => $e->getMessage(),
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->telegram->answerCallback($cbId, '💥 Server error. Check logs.', true);
        }
    }

    // ─── Edit Signal: Step 1 — Show field menu ────────────────────────────────

    private function editSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✏️ EDIT SIGNAL', ['id' => $id, 'msg_id' => $msgId]);

        try {
            $signal = Signal::find($id);
            if (!$signal) {
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }

            // Store the original preview msg ID so we can restore it on cancel
            Cache::put("edit_origin:{$chatId}:{$id}", $msgId, now()->addMinutes(30));

            // Initialize empty prompt list for this edit session
            Cache::put("edit_prompts:{$chatId}:{$id}", [], now()->addMinutes(30));

            $this->telegram->showEditMenu($signal, $chatId, $msgId);
            $this->telegram->answerCallback($cbId, '✏️ Choose a field to edit.');

            Log::channel('telegram')->info('✅ EDIT MENU SHOWN');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 EDIT SIGNAL ERROR', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            $this->telegram->answerCallback($cbId, '💥 Edit failed. Check logs.', true);
        }
    }

    // ─── Edit Signal: Step 2 — Field selected ────────────────────────────────

    private function editField(int $signalId, ?string $field, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('✏️ FIELD SELECTED', ['signal_id' => $signalId, 'field' => $field]);

        try {
            if (!$field) {
                $this->telegram->answerCallback($cbId, '⚠️ No field specified.', true);
                return;
            }

            $signal = Signal::find($signalId);
            if (!$signal) {
                $this->telegram->answerCallback($cbId, '⚠️ Signal not found.', true);
                return;
            }

            // Save edit state
            Cache::put("edit_state:{$chatId}", [
                'signal_id'     => $signalId,
                'field'         => $field,
                'edit_menu_msg' => $msgId,  // the edit menu message ID
            ], now()->addMinutes(5));

            Log::channel('telegram')->info('💾 EDIT STATE SAVED', ['state' => Cache::get("edit_state:{$chatId}")]);

            // Send prompt message and store its ID
            $promptMsgId = $this->telegram->askForFieldValue($signal, $field, $chatId);
            Log::channel('telegram')->info('📤 PROMPT SENT', ['prompt_msg_id' => $promptMsgId]);

            // Add prompt msg ID to the list for later deletion
            $prompts   = Cache::get("edit_prompts:{$chatId}:{$signalId}", []);
            $prompts[] = $promptMsgId;
            Cache::put("edit_prompts:{$chatId}:{$signalId}", $prompts, now()->addMinutes(30));

            Log::channel('telegram')->info('💾 PROMPT IDS STORED', ['all_prompts' => $prompts]);

            $this->telegram->answerCallback($cbId, "✏️ Type the new {$field} value.");

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 EDIT FIELD ERROR', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            $this->telegram->answerCallback($cbId, '💥 Field select failed.', true);
        }
    }

    // ─── Edit Signal: Step 3 — Admin types value ─────────────────────────────

    private function handleTextMessage(array $message): void
    {
        $chatId = (string) $message['chat']['id'];
        $text   = trim($message['text'] ?? '');
        $userId = $message['from']['id'];
        $name   = trim(($message['from']['first_name'] ?? '') . ' ' . ($message['from']['last_name'] ?? ''));

        Log::channel('telegram')->info('💬 TEXT MESSAGE', ['chat_id' => $chatId, 'user_id' => $userId, 'text' => $text]);

        if (!$this->telegram->isAdmin($userId)) return;

        $state = Cache::get("edit_state:{$chatId}");
        Log::channel('telegram')->info('🔍 EDIT STATE', ['state' => $state]);

        if (!$state) {
            Log::channel('telegram')->info('ℹ️ NO EDIT STATE — ignoring');
            return;
        }

        Cache::forget("edit_state:{$chatId}");

        $signal = Signal::find($state['signal_id']);
        if (!$signal) {
            Log::channel('telegram')->error('❌ SIGNAL NOT FOUND', ['id' => $state['signal_id']]);
            return;
        }

        try {
            $this->applyFieldEdit($signal, $state['field'], $text, $chatId, $state['edit_menu_msg']);
        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 APPLY EDIT ERROR', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            $this->telegram->sendMessage([
                'chat_id'    => $chatId,
                'text'       => "💥 Failed to apply edit.\n\n`{$e->getMessage()}`",
                'parse_mode' => 'Markdown',
            ]);
        }
    }

    private function applyFieldEdit(Signal $signal, string $field, string $value, string $chatId, string $editMenuMsgId): void
    {
        Log::channel('telegram')->info('✏️ APPLYING EDIT', ['field' => $field, 'value' => $value]);

        $update = match ($field) {
            'entry' => $this->parseEntry($value),
            'sl'        => ['sl'        => (float) $value],
            'tp1'       => ['tp1'       => (float) $value],
            'tp2'       => ['tp2'       => (float) $value],
            'tp3'       => ['tp3'       => (float) $value],
            'direction' => ['direction' => strtoupper(trim($value))],
            'pair'      => ['pair'      => strtoupper(trim($value))],
            'channel'   => ['channel'   => strtolower(trim($value))],
            default     => null,
        };

        if (!$update) {
            Log::channel('telegram')->error('❌ UNKNOWN FIELD', ['field' => $field]);
            $this->telegram->sendMessage([
                'chat_id'    => $chatId,
                'text'       => "⚠️ Unknown field: `{$field}`",
                'parse_mode' => 'Markdown',
            ]);
            return;
        }

        $signal->update($update);
        $signal->refresh();

        // Regenerate signal text
        $signal->update([
            'signal_text' => $this->formatter->formatSignal($signal),
            'status'      => 'pending_approval',
        ]);
        $signal->refresh();

        Log::channel('telegram')->info('✅ DB UPDATED', ['fields' => $update]);

        // Store confirmation msg ID for deletion later
        $confirmRes = $this->telegram->sendMessage([
            'chat_id'    => $chatId,
            'text'       => "✅ *{$field}* updated to `{$value}`",
            'parse_mode' => 'Markdown',
        ]);
        $confirmMsgId = (string) ($confirmRes['result']['message_id'] ?? '');

        // Store confirm msg id in prompts list too
        if ($confirmMsgId) {
            $prompts   = Cache::get("edit_prompts:{$chatId}:{$signal->id}", []);
            $prompts[] = $confirmMsgId;
            Cache::put("edit_prompts:{$chatId}:{$signal->id}", $prompts, now()->addMinutes(30));
            Log::channel('telegram')->info('💾 CONFIRM MSG STORED', ['all_prompts' => $prompts]);
        }

        // Refresh edit menu with updated values
        $this->telegram->showEditMenu($signal, $chatId, $editMenuMsgId);

        Log::channel('telegram')->info('✅ EDIT MENU REFRESHED WITH NEW VALUES');
    }

    private function parseEntry(string $value): array
    {
        $normalized = preg_replace('/\s*[-–]\s*/', '-', $value);
        if (str_contains($normalized, '-')) {
            [$min, $max] = explode('-', $normalized, 2);
            return ['entry_min' => (float) trim($min), 'entry_max' => (float) trim($max)];
        }
        return ['entry_min' => (float) $value, 'entry_max' => null];
    }

    // ─── Cancel Edit ──────────────────────────────────────────────────────────

    private function cancelEdit(int $signalId, string $chatId, string $msgId, string $cbId): void
    {
        Log::channel('telegram')->info('🚫 CANCEL EDIT', ['signal_id' => $signalId]);

        Cache::forget("edit_state:{$chatId}");

        // Delete all prompt messages
        $prompts = Cache::get("edit_prompts:{$chatId}:{$signalId}", []);
        foreach ($prompts as $pMsgId) {
            $this->telegram->deleteMessage($chatId, $pMsgId);
        }
        Cache::forget("edit_prompts:{$chatId}:{$signalId}");
        Cache::forget("edit_origin:{$chatId}:{$signalId}");

        // Restore the edit menu message back to approval buttons
        $signal = Signal::find($signalId);
        if ($signal) {
            $this->telegram->editMessageWithApprovalButtons($signal, $chatId, $msgId);
        }

        $this->telegram->answerCallback($cbId, '🚫 Edit cancelled.');
    }

    // ─── Resubmit Signal ─────────────────────────────────────────────────────

    private function resubmitSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $signal = Signal::find($id);
        if (!$signal) { $this->telegram->answerCallback($cbId, '⚠️ Not found.', true); return; }

        $signal->update(['status' => 'pending_approval']);
        $this->telegram->editMessageWithApprovalButtons($signal, $chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🔁 Re-submitted!');
    }

    // ─── Delete Signal ────────────────────────────────────────────────────────

    private function deleteSignal(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $signal = Signal::find($id);
        if ($signal) $signal->delete();

        $this->telegram->deleteMessage($chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🗑️ Signal deleted.');
    }

    // ─── Result Handlers ──────────────────────────────────────────────────────

    private function approveResult(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        try {
            $result = SignalResult::find($id);
            if (!$result) { $this->telegram->answerCallback($cbId, '⚠️ Not found.', true); return; }

            $result->update(['status' => 'approved', 'approved_by' => $userId, 'approved_at' => now()]);
            $channelMsgId = $this->telegram->postResultToChannel($result);
            $result->update(['status' => 'posted', 'telegram_message_id' => $channelMsgId]);

            $this->log('approved_result', 'signal_result', $id, $userId, $name);
            $this->telegram->showApprovedResult($result, $chatId, $msgId, $name);
            $this->telegram->answerCallback($cbId, '✅ Result posted!');

        } catch (\Throwable $e) {
            Log::channel('telegram')->error('💥 APPROVE RESULT ERROR', ['error' => $e->getMessage()]);
            $this->telegram->answerCallback($cbId, '💥 Error.', true);
        }
    }

    private function rejectResult(int $id, int $userId, string $name, string $chatId, string $msgId, string $cbId): void
    {
        $result = SignalResult::find($id);
        if (!$result) { $this->telegram->answerCallback($cbId, '⚠️ Not found.', true); return; }

        $result->update(['status' => 'rejected']);
        $this->log('rejected_result', 'signal_result', $id, $userId, $name);
        $this->telegram->showRejectedResult($result, $chatId, $msgId, $name);
        $this->telegram->answerCallback($cbId, '❌ Rejected.');
    }

    private function resubmitResult(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $result = SignalResult::find($id);
        if (!$result) { $this->telegram->answerCallback($cbId, '⚠️ Not found.', true); return; }

        $result->update(['status' => 'pending_approval']);
        $this->telegram->editResultWithApprovalButtons($result, $chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🔁 Re-submitted!');
    }

    private function deleteResult(int $id, string $chatId, string $msgId, string $cbId): void
    {
        $result = SignalResult::find($id);
        if ($result) $result->delete();

        $this->telegram->deleteMessage($chatId, $msgId);
        $this->telegram->answerCallback($cbId, '🗑️ Deleted.');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function unknownAction(string $action, string $cbId): void
    {
        Log::channel('telegram')->error('❓ UNKNOWN ACTION', ['action' => $action]);
        $this->telegram->answerCallback($cbId, "⚠️ Unknown: {$action}", true);
    }

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
