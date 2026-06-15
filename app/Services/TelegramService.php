<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
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

    // ─── Core HTTP Helpers ───────────────────────────────────────────────────

    private function sendMessage(array $payload): array
    {
        return Http::post("{$this->baseUrl}/sendMessage", $payload)->json();
    }

    private function editMessageText(array $payload): array
    {
        return Http::post("{$this->baseUrl}/editMessageText", $payload)->json();
    }

    private function editMessageReplyMarkup(array $payload): array
    {
        return Http::post("{$this->baseUrl}/editMessageReplyMarkup", $payload)->json();
    }

    public function answerCallback(string $callbackQueryId, string $text, bool $alert = false): void
    {
        Http::post("{$this->baseUrl}/answerCallbackQuery", [
            'callback_query_id' => $callbackQueryId,
            'text'              => $text,
            'show_alert'        => $alert,
        ]);
    }

    public function deleteMessage(string $chatId, string $messageId): void
    {
        Http::post("{$this->baseUrl}/deleteMessage", [
            'chat_id'    => $chatId,
            'message_id' => $messageId,
        ]);
    }

    // ─── Signal Preview ──────────────────────────────────────────────────────

    public function sendSignalPreview(Signal $signal): void
    {
        $keyboard = $this->signalApprovalKeyboard($signal->id);
        $header   = "📋 *SIGNAL PREVIEW — \#{$signal->id}*\n";
        $channel  = strtoupper($signal->channel);
        $footer   = "\n📢 Channel: *{$channel}*";

        $result = $this->sendMessage([
            'chat_id'      => $this->approvalGroup,
            'text'         => $header . "\n" . $signal->signal_text . $footer,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);

        if (!empty($result['result']['message_id'])) {
            TelegramMessage::create([
                'entity_type' => 'signal',
                'entity_id'   => $signal->id,
                'chat_id'     => $this->approvalGroup,
                'message_id'  => $result['result']['message_id'],
                'type'        => 'preview',
            ]);
        }
    }

    // ─── Result Preview ──────────────────────────────────────────────────────

    public function sendResultPreview(SignalResult $result): void
    {
        $keyboard = $this->resultApprovalKeyboard($result->id);
        $header   = "📋 *RESULT PREVIEW — Signal \#{$result->signal_id}*\n\n";

        $res = $this->sendMessage([
            'chat_id'      => $this->approvalGroup,
            'text'         => $header . $result->result_text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);

        if (!empty($res['result']['message_id'])) {
            TelegramMessage::create([
                'entity_type' => 'signal_result',
                'entity_id'   => $result->id,
                'chat_id'     => $this->approvalGroup,
                'message_id'  => $res['result']['message_id'],
                'type'        => 'preview',
            ]);
        }
    }

    // ─── Post to Channel ─────────────────────────────────────────────────────

    public function postSignalToChannel(Signal $signal): string
    {
        $chatId = $signal->channel === 'vip' ? $this->vipChannel : $this->publicChannel;

        $res = $this->sendMessage([
            'chat_id'    => $chatId,
            'text'       => $signal->signal_text,
            'parse_mode' => 'Markdown',
        ]);

        return $res['result']['message_id'] ?? '';
    }

    public function postResultToChannel(SignalResult $result): string
    {
        $chatId = $result->signal->channel === 'vip' ? $this->vipChannel : $this->publicChannel;

        $res = $this->sendMessage([
            'chat_id'    => $chatId,
            'text'       => $result->result_text,
            'parse_mode' => 'Markdown',
        ]);

        return $res['result']['message_id'] ?? '';
    }

    // ─── Edit Flow ───────────────────────────────────────────────────────────

    /**
     * Replace the preview message with an edit menu showing
     * all editable fields as buttons. Admin taps a field → bot
     * sends a prompt asking for the new value.
     */
    public function showEditMenu(Signal $signal, string $chatId, string $messageId): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '📍 Entry',    'callback_data' => "edit_field:{$signal->id}:entry"],
                    ['text' => '🛑 SL',       'callback_data' => "edit_field:{$signal->id}:sl"],
                ],
                [
                    ['text' => '🎯 TP1',      'callback_data' => "edit_field:{$signal->id}:tp1"],
                    ['text' => '🎯 TP2',      'callback_data' => "edit_field:{$signal->id}:tp2"],
                    ['text' => '🎯 TP3',      'callback_data' => "edit_field:{$signal->id}:tp3"],
                ],
                [
                    ['text' => '🔄 Direction','callback_data' => "edit_field:{$signal->id}:direction"],
                    ['text' => '💱 Pair',     'callback_data' => "edit_field:{$signal->id}:pair"],
                ],
                [
                    ['text' => '📢 Channel',  'callback_data' => "edit_field:{$signal->id}:channel"],
                ],
                [
                    ['text' => '✅ Done — Approve & Post', 'callback_data' => "approve_signal:{$signal->id}"],
                    ['text' => '❌ Cancel',                'callback_data' => "reject_signal:{$signal->id}"],
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
            "• TP1: `{$signal->tp1}` | TP2: `{$signal->tp2}` | TP3: `{$signal->tp3}`",
            "• Channel: `{$signal->channel}`",
            "",
            "Tap a field below to update it.",
        ]);

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    /**
     * Ask admin to type a new value for a specific field.
     * Sends a NEW message with a cancel button.
     */
    public function askForFieldValue(Signal $signal, string $field, string $chatId): void
    {
        $labels = [
            'entry'     => 'Entry price (e.g. `1.2800` or `1.2800-1.2820` for range)',
            'sl'        => 'Stop Loss price (e.g. `1.2750`)',
            'tp1'       => 'TP1 price (e.g. `1.2850`)',
            'tp2'       => 'TP2 price (e.g. `1.2900`)',
            'tp3'       => 'TP3 price (e.g. `1.2950`)',
            'direction' => 'Direction — type `BUY` or `SELL`',
            'pair'      => 'Pair (e.g. `GBP/USD` or `XAU/USD`)',
            'channel'   => 'Channel — type `public` or `vip`',
        ];

        $keyboard = [
            'inline_keyboard' => [[
                ['text' => '🚫 Cancel Edit', 'callback_data' => "cancel_edit:{$signal->id}"],
            ]]
        ];

        $this->sendMessage([
            'chat_id'      => $chatId,
            'text'         => "✏️ *Signal \#{$signal->id} — Edit {$field}*\n\nReply with the new value for:\n👉 {$labels[$field]}\n\n_Type your value in the next message._",
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    // ─── Reject Flow ─────────────────────────────────────────────────────────

    /**
     * On reject: update the preview message to show rejected status
     * AND offer a "Re-submit" button so admin can reconsider.
     */
    public function showRejectedSignal(Signal $signal, string $chatId, string $messageId, string $rejectedBy): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '🔁 Re-submit for Approval', 'callback_data' => "resubmit_signal:{$signal->id}"],
                    ['text' => '🗑️ Delete',                 'callback_data' => "delete_signal:{$signal->id}"],
                ]
            ]
        ];

        $entry = $signal->entry_max
            ? "{$signal->entry_min} – {$signal->entry_max}"
            : $signal->entry_min;

        $text = implode("\n", [
            "❌ *SIGNAL \#{$signal->id} — REJECTED*",
            "",
            "Rejected by: *{$rejectedBy}*",
            "",
            "📊 {$signal->pair} {$signal->direction}",
            "📍 Entry: `{$entry}`",
            "🛑 SL: `{$signal->sl}`",
            "",
            "Use *Re-submit* to send it for approval again,",
            "or *Delete* to remove it permanently.",
        ]);

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    public function showRejectedResult(SignalResult $result, string $chatId, string $messageId, string $rejectedBy): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '🔁 Re-submit', 'callback_data' => "resubmit_result:{$result->id}"],
                    ['text' => '🗑️ Delete',    'callback_data' => "delete_result:{$result->id}"],
                ]
            ]
        ];

        $text = implode("\n", [
            "❌ *RESULT \#{$result->id} — REJECTED*",
            "",
            "Rejected by: *{$rejectedBy}*",
            "Signal: \#{$result->signal_id} | Type: *{$result->result_type}*",
            "",
            "Use *Re-submit* to send for approval again.",
        ]);

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    // ─── Approved Message ────────────────────────────────────────────────────

    public function showApprovedSignal(Signal $signal, string $chatId, string $messageId, string $approvedBy): void
    {
        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => "✅ *Signal \#{$signal->id} APPROVED & POSTED*\n\nApproved by: *{$approvedBy}*\n📊 {$signal->pair} {$signal->direction}\n📢 Channel: *{$signal->channel}*",
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode(['inline_keyboard' => []]),
        ]);
    }

    public function showApprovedResult(SignalResult $result, string $chatId, string $messageId, string $approvedBy): void
    {
        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => "✅ *Result \#{$result->id} APPROVED & POSTED*\n\nApproved by: *{$approvedBy}*\nSignal: \#{$result->signal_id} | Type: *{$result->result_type}*",
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode(['inline_keyboard' => []]),
        ]);
    }

    // ─── Keyboard Builders ───────────────────────────────────────────────────

    public function signalApprovalKeyboard(int $signalId): array
    {
        return [
            'inline_keyboard' => [
                [
                    ['text' => '✅ Approve & Post', 'callback_data' => "approve_signal:{$signalId}"],
                    ['text' => '✏️ Edit',           'callback_data' => "edit_signal:{$signalId}"],
                    ['text' => '❌ Reject',          'callback_data' => "reject_signal:{$signalId}"],
                ]
            ]
        ];
    }

    public function resultApprovalKeyboard(int $resultId): array
    {
        return [
            'inline_keyboard' => [
                [
                    ['text' => '✅ Approve & Post', 'callback_data' => "approve_result:{$resultId}"],
                    ['text' => '❌ Reject',          'callback_data' => "reject_result:{$resultId}"],
                ]
            ]
        ];
    }

    // ─── Misc ────────────────────────────────────────────────────────────────

    public function isAdmin(int $telegramUserId): bool
    {
        $ids = array_map('trim', explode(',', config('app.telegram_admin_ids', '')));
        return in_array((string) $telegramUserId, $ids);
    }

    public function setWebhook(string $url): array
    {
        return Http::post("{$this->baseUrl}/setWebhook", ['url' => $url])->json();
    }

    public function updateApprovalMessage(string $chatId, string $messageId, string $text): void
    {
        $this->editMessageText([
            'chat_id'    => $chatId,
            'message_id' => $messageId,
            'text'       => $text,
            'parse_mode' => 'Markdown',
        ]);
    }

    public function editMessageWithApprovalButtons(Signal $signal, string $chatId, string $messageId): void
    {
        $keyboard = $this->signalApprovalKeyboard($signal->id);
        $header   = "📋 *SIGNAL PREVIEW — \#{$signal->id}* _(Re-submitted)_\n\n";
        $channel  = strtoupper($signal->channel);
        $footer   = "\n\n📢 Channel: *{$channel}*";

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $header . $signal->signal_text . $footer,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }

    public function editResultWithApprovalButtons(SignalResult $result, string $chatId, string $messageId): void
    {
        $keyboard = $this->resultApprovalKeyboard($result->id);
        $header   = "📋 *RESULT PREVIEW — Signal \#{$result->signal_id}* _(Re-submitted)_\n\n";

        $this->editMessageText([
            'chat_id'      => $chatId,
            'message_id'   => $messageId,
            'text'         => $header . $result->result_text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);
    }
}
