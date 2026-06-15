<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Signal;
use App\Models\SignalResult;
use App\Models\TelegramMessage;

class TelegramService
{
    private string $baseUrl;
    private string $approvalGroup;
    private string $publicChannel;
    private string $vipChannel;

    public function __construct()
    {
        $token               = config('telegram.bots.mybot.token');
        $this->baseUrl       = "https://api.telegram.org/bot{$token}";
        $this->approvalGroup = config('app.telegram_approval_group_id');
        $this->publicChannel = config('app.telegram_public_channel_id');
        $this->vipChannel    = config('app.telegram_vip_channel_id');
    }

    // ─── Core HTTP ────────────────────────────────────────────────────────────

    public function sendMessage(array $payload): array
    {
        $res = Http::post("{$this->baseUrl}/sendMessage", $payload)->json();
        Log::channel('telegram')->info('📤 sendMessage', ['payload' => $payload, 'response' => $res]);
        return $res;
    }

    public function editMessageText(array $payload): array
    {
        $res = Http::post("{$this->baseUrl}/editMessageText", $payload)->json();
        Log::channel('telegram')->info('📝 editMessageText', ['payload' => $payload, 'response' => $res]);
        return $res;
    }

    public function deleteMessage(string $chatId, string $messageId): void
    {
        $res = Http::post("{$this->baseUrl}/deleteMessage", [
            'chat_id'    => $chatId,
            'message_id' => $messageId,
        ])->json();
        Log::channel('telegram')->info('🗑️ deleteMessage', [
            'chat_id'    => $chatId,
            'message_id' => $messageId,
            'response'   => $res,
        ]);
    }

    public function answerCallback(string $callbackQueryId, string $text, bool $alert = false): void
    {
        Http::post("{$this->baseUrl}/answerCallbackQuery", [
            'callback_query_id' => $callbackQueryId,
            'text'              => $text,
            'show_alert'        => $alert,
        ]);
    }

    // ─── Signal: Initial Preview ──────────────────────────────────────────────

    /**
     * Sends brand new signal preview with Approve / Edit / Reject buttons.
     * Stores the message_id in DB for future reference.
     */
    public function sendSignalPreview(Signal $signal): string
    {
        $keyboard = $this->signalApprovalKeyboard($signal->id);
        $text     = $this->buildPreviewText($signal);

        $res = $this->sendMessage([
            'chat_id'      => $this->approvalGroup,
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);

        $msgId = (string) ($res['result']['message_id'] ?? '');

        if ($msgId) {
            TelegramMessage::create([
                'entity_type' => 'signal',
                'entity_id'   => $signal->id,
                'chat_id'     => $this->approvalGroup,
                'message_id'  => $msgId,
                'type'        => 'preview',
            ]);
        }

        return $msgId;
    }

    // ─── Signal: Edit Menu ────────────────────────────────────────────────────

    /**
     * Replaces the preview message with the field-selector edit menu.
     */
    public function showEditMenu(Signal $signal, string $chatId, string $messageId): array
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '📍 Entry',     'callback_data' => "edit_field:{$signal->id}:entry"],
                    ['text' => '🛑 SL',        'callback_data' => "edit_field:{$signal->id}:sl"],
                ],
                [
                    ['text' => '🎯 TP1',       'callback_data' => "edit_field:{$signal->id}:tp1"],
                    ['text' => '🎯 TP2',       'callback_data' => "edit_field:{$signal->id}:tp2"],
                    ['text' => '🎯 TP3',       'callback_data' => "edit_field:{$signal->id}:tp3"],
                ],
                [
                    ['text' => '🔄 Direction', 'callback_data' => "edit_field:{$signal->id}:direction"],
                    ['text' => '💱 Pair',      'callback_data' => "edit_field:{$signal->id}:pair"],
                ],
                [
                    ['text' => '📢 Channel',   'callback_data' => "edit_field:{$signal->id}:channel"],
                ],
                [
                    ['text' => '✅ Done — Approve & Post', 'callback_data' => "approve_from_edit:{$signal->id}"],
                    ['text' => '🚫 Cancel',               'callback_data' => "cancel_edit:{$signal->id}"],
                ],
            ]
        ];

        $entry = $signal->entry_max
            ? "{$signal->entry_min} – {$signal->entry_max}"
            : $signal->entry_min;

        $text = implode("\n", [
            "✏️ *EDIT SIGNAL \#{$signal->id}*",
            "",
            "Current values:",
            "• Pair: `{$signal->pair}` | Direction: `{$signal->direction}`",
            "• Entry: `{$entry}`",
            "• SL: `{$signal->sl}`",
            "• TP1: `" . ($signal->tp1 ?? '—') . "` | TP2: `" . ($signal->tp2 ?? '—') . "` | TP3: `" . ($signal->tp3 ?? '—') . "`",
            "• Channel: `{$signal->channel}`",
            "",
            "👇 Tap a field to update it:",
        ]);

        return $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    // ─── Signal: Ask for Field Value ──────────────────────────────────────────

    /**
     * Sends a NEW message prompting admin to type the new value.
     * Returns the message_id so caller can store it for later deletion.
     */
    public function askForFieldValue(Signal $signal, string $field, string $chatId): string
    {
        $labels = [
            'entry'     => 'Entry price — single: `1.2800` or range: `1.2800-1.2820`',
            'sl'        => 'Stop Loss — e.g. `1.2750`',
            'tp1'       => 'TP1 — e.g. `1.2850`',
            'tp2'       => 'TP2 — e.g. `1.2900`',
            'tp3'       => 'TP3 — e.g. `1.2950`',
            'direction' => 'Direction — type `BUY` or `SELL`',
            'pair'      => 'Pair — e.g. `GBP/USD` or `XAU/USD`',
            'channel'   => 'Channel — type `public` or `vip`',
        ];

        $keyboard = [
            'inline_keyboard' => [[
                ['text' => '🚫 Cancel Edit', 'callback_data' => "cancel_edit:{$signal->id}"],
            ]]
        ];

        $res = $this->sendMessage([
            'chat_id'      => $chatId,
            'text'         => implode("\n", [
                "✏️ *Signal \#{$signal->id} — Editing: {$field}*",
                "",
                "👉 " . ($labels[$field] ?? $field),
                "",
                "_Just type the new value and send it._",
            ]),
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);

        return (string) ($res['result']['message_id'] ?? '');
    }

    // ─── Signal: Post to Channel ──────────────────────────────────────────────

    public function postSignalToChannel(Signal $signal): string
    {
        $chatId = $signal->channel === 'vip' ? $this->vipChannel : $this->publicChannel;

        $res = $this->sendMessage([
            'chat_id'    => $chatId,
            'text'       => $signal->signal_text,
            'parse_mode' => 'Markdown',
        ]);

        return (string) ($res['result']['message_id'] ?? '');
    }

    // ─── Signal: Final Clean Approved Message ─────────────────────────────────

    /**
     * THE KEY FIX:
     * 1. Delete the edit menu message
     * 2. Delete all prompt messages (ask-for-value messages)
     * 3. Post to channel
     * 4. Send a clean NEW approved confirmation message in group
     */
    public function postCleanApproved(Signal $signal, string $chatId, string $editMenuMsgId, array $promptMsgIds, string $approvedBy): void
    {
        // 1 — Delete edit menu message
        $this->deleteMessage($chatId, $editMenuMsgId);

        // 2 — Delete all prompt + confirmation messages
        foreach ($promptMsgIds as $promptMsgId) {
            if ($promptMsgId) $this->deleteMessage($chatId, $promptMsgId);
        }

        // 3 — Post to channel
        $channelMsgId = $this->postSignalToChannel($signal);
        $signal->update(['telegram_message_id' => $channelMsgId]);

        // 4 — Send clean approved message to approval group
        $entry = $signal->entry_max
            ? "{$signal->entry_min} – {$signal->entry_max}"
            : $signal->entry_min;

        $lines = array_filter([
            "✅ *Signal \#{$signal->id} — APPROVED & POSTED*",
            "",
            "👤 Approved by: *{$approvedBy}*",
            "",
            "📊 *{$signal->pair} {$signal->direction}*",
            "📍 Entry: `{$entry}`",
            "🛑 SL: `{$signal->sl}`",
            $signal->tp1 ? "🎯 TP1: `{$signal->tp1}`" : null,
            $signal->tp2 ? "🎯 TP2: `{$signal->tp2}`" : null,
            $signal->tp3 ? "🎯 TP3: `{$signal->tp3}`" : null,
            "",
            "📢 Channel: *{$signal->channel}*",
        ]);

        $this->sendMessage([
            'chat_id'    => $chatId,
            'text'       => implode("\n", $lines),
            'parse_mode' => 'Markdown',
        ]);
    }

    // ─── Signal: Approved (from normal flow, no edit) ─────────────────────────

    /**
     * Used when approve is clicked directly WITHOUT going through edit.
     * Just edits the existing preview message — no deletion needed.
     */
    public function showApprovedSignal(Signal $signal, string $chatId, string $messageId, string $approvedBy): void
    {
        $entry = $signal->entry_max
            ? "{$signal->entry_min} – {$signal->entry_max}"
            : $signal->entry_min;

        $text = implode("\n", array_filter([
            "✅ *Signal \#{$signal->id} — APPROVED & POSTED*",
            "",
            "👤 Approved by: *{$approvedBy}*",
            "",
            "📊 *{$signal->pair} {$signal->direction}*",
            "📍 Entry: `{$entry}`",
            "🛑 SL: `{$signal->sl}`",
            $signal->tp1 ? "🎯 TP1: `{$signal->tp1}`" : null,
            $signal->tp2 ? "🎯 TP2: `{$signal->tp2}`" : null,
            $signal->tp3 ? "🎯 TP3: `{$signal->tp3}`" : null,
            "",
            "📢 Channel: *{$signal->channel}*",
        ]));

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode(['inline_keyboard' => []]),
        ]);
    }

    // ─── Signal: Rejected ─────────────────────────────────────────────────────

    public function showRejectedSignal(Signal $signal, string $chatId, string $messageId, string $rejectedBy): void
    {
        $keyboard = [
            'inline_keyboard' => [[
                ['text' => '🔁 Re-submit', 'callback_data' => "resubmit_signal:{$signal->id}"],
                ['text' => '🗑️ Delete',   'callback_data' => "delete_signal:{$signal->id}"],
            ]]
        ];

        $entry = $signal->entry_max
            ? "{$signal->entry_min} – {$signal->entry_max}"
            : $signal->entry_min;

        $text = implode("\n", [
            "❌ *Signal \#{$signal->id} — REJECTED*",
            "",
            "Rejected by: *{$rejectedBy}*",
            "",
            "📊 *{$signal->pair} {$signal->direction}*",
            "📍 Entry: `{$entry}`",
            "🛑 SL: `{$signal->sl}`",
            "",
            "Tap *Re-submit* to send for approval again.",
        ]);

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    // ─── Result Methods ───────────────────────────────────────────────────────

    public function sendResultPreview(SignalResult $result): string
    {
        $keyboard = $this->resultApprovalKeyboard($result->id);
        $header   = "📋 *RESULT PREVIEW — Signal \#{$result->signal_id}*\n\n";

        $res = $this->sendMessage([
            'chat_id'      => $this->approvalGroup,
            'text'         => $header . $result->result_text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);

        $msgId = (string) ($res['result']['message_id'] ?? '');

        if ($msgId) {
            TelegramMessage::create([
                'entity_type' => 'signal_result',
                'entity_id'   => $result->id,
                'chat_id'     => $this->approvalGroup,
                'message_id'  => $msgId,
                'type'        => 'preview',
            ]);
        }

        return $msgId;
    }

    public function postResultToChannel(SignalResult $result): string
    {
        $chatId = $result->signal->channel === 'vip' ? $this->vipChannel : $this->publicChannel;

        $res = $this->sendMessage([
            'chat_id'    => $chatId,
            'text'       => $result->result_text,
            'parse_mode' => 'Markdown',
        ]);

        return (string) ($res['result']['message_id'] ?? '');
    }

    public function showApprovedResult(SignalResult $result, string $chatId, string $messageId, string $approvedBy): void
    {
        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => "✅ *Result \#{$result->id} — APPROVED & POSTED*\n\nApproved by: *{$approvedBy}*\nSignal: \#{$result->signal_id} | Type: *{$result->result_type}*",
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode(['inline_keyboard' => []]),
        ]);
    }

    public function showRejectedResult(SignalResult $result, string $chatId, string $messageId, string $rejectedBy): void
    {
        $keyboard = [
            'inline_keyboard' => [[
                ['text' => '🔁 Re-submit', 'callback_data' => "resubmit_result:{$result->id}"],
                ['text' => '🗑️ Delete',   'callback_data' => "delete_result:{$result->id}"],
            ]]
        ];

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => implode("\n", [
                "❌ *Result \#{$result->id} — REJECTED*",
                "",
                "Rejected by: *{$rejectedBy}*",
                "Signal: \#{$result->signal_id} | Type: *{$result->result_type}*",
                "",
                "Tap *Re-submit* to send for approval again.",
            ]),
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    public function editMessageWithApprovalButtons(Signal $signal, string $chatId, string $messageId): void
    {
        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $this->buildPreviewText($signal),
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($this->signalApprovalKeyboard($signal->id)),
        ]);
    }

    public function editResultWithApprovalButtons(SignalResult $result, string $chatId, string $messageId): void
    {
        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => "📋 *RESULT PREVIEW — Signal \#{$result->signal_id}* _(Re-submitted)_\n\n" . $result->result_text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($this->resultApprovalKeyboard($result->id)),
        ]);
    }

    // ─── Keyboard Builders ────────────────────────────────────────────────────

    public function signalApprovalKeyboard(int $signalId): array
    {
        return [
            'inline_keyboard' => [[
                ['text' => '✅ Approve & Post', 'callback_data' => "approve_signal:{$signalId}"],
                ['text' => '✏️ Edit',           'callback_data' => "edit_signal:{$signalId}"],
                ['text' => '❌ Reject',          'callback_data' => "reject_signal:{$signalId}"],
            ]]
        ];
    }

    public function resultApprovalKeyboard(int $resultId): array
    {
        return [
            'inline_keyboard' => [[
                ['text' => '✅ Approve & Post', 'callback_data' => "approve_result:{$resultId}"],
                ['text' => '❌ Reject',          'callback_data' => "reject_result:{$resultId}"],
            ]]
        ];
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    public function isAdmin(int $telegramUserId): bool
    {
        $ids = array_map('trim', explode(',', config('app.telegram_admin_ids', '')));
        return in_array((string) $telegramUserId, $ids);
    }

    public function setWebhook(string $url): array
    {
        return Http::post("{$this->baseUrl}/setWebhook", ['url' => $url])->json();
    }

    private function buildPreviewText(Signal $signal): string
    {
        $entry   = $signal->entry_max
            ? "{$signal->entry_min} – {$signal->entry_max}"
            : $signal->entry_min;
        $channel = strtoupper($signal->channel);

        return implode("\n", array_filter([
            "📋 *SIGNAL PREVIEW — \#{$signal->id}*",
            "",
            $signal->signal_text,
            "",
            "📢 Channel: *{$channel}*",
        ]));
    }
}
