<?php
namespace App\Services;

use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Signal;
use App\Models\SignalResult;
use App\Models\TelegramMessage;

class TelegramService
{
    private string $approvalGroup;
    private string $publicChannel;
    private string $vipChannel;

    public function __construct()
    {
        $this->approvalGroup = config('app.telegram_approval_group_id');
        $this->publicChannel = config('app.telegram_public_channel_id');
        $this->vipChannel    = config('app.telegram_vip_channel_id');
    }

    /** Send signal preview to approval group with inline buttons */
    public function sendSignalPreview(Signal $signal): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '✅ Approve & Post', 'callback_data' => "approve_signal:{$signal->id}"],
                    ['text' => '✏️ Edit',           'callback_data' => "edit_signal:{$signal->id}"],
                    ['text' => '❌ Reject',          'callback_data' => "reject_signal:{$signal->id}"],
                ]
            ]
        ];

        $header  = "📋 *SIGNAL PREVIEW — #{$signal->id}*\n\n";
        $channel = strtoupper($signal->channel);
        $footer  = "\n\n📢 Channel: *{$channel}*";

        $response = Telegram::sendMessage([
            'chat_id'      => $this->approvalGroup,
            'text'         => $header . $signal->signal_text . $footer,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);

        TelegramMessage::create([
            'entity_type' => 'signal',
            'entity_id'   => $signal->id,
            'chat_id'     => $this->approvalGroup,
            'message_id'  => $response->messageId,
            'type'        => 'preview',
        ]);
    }

    /** Post approved signal to public/VIP channel */
    public function postSignalToChannel(Signal $signal): string
    {
        $chatId = $signal->channel === 'vip'
            ? $this->vipChannel
            : $this->publicChannel;

        $response = Telegram::sendMessage([
            'chat_id'    => $chatId,
            'text'       => $signal->signal_text,
            'parse_mode' => 'Markdown',
        ]);

        return $response->messageId;
    }

    /** Send result preview to approval group */
    public function sendResultPreview(SignalResult $result): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '✅ Approve & Post', 'callback_data' => "approve_result:{$result->id}"],
                    ['text' => '❌ Reject',          'callback_data' => "reject_result:{$result->id}"],
                ]
            ]
        ];

        $header = "📋 *RESULT PREVIEW — Signal #{$result->signal_id}*\n\n";

        $response = Telegram::sendMessage([
            'chat_id'      => $this->approvalGroup,
            'text'         => $header . $result->result_text,
            'parse_mode'   => 'Markdown',
            'reply_markup' => json_encode($keyboard),
        ]);

        TelegramMessage::create([
            'entity_type' => 'signal_result',
            'entity_id'   => $result->id,
            'chat_id'     => $this->approvalGroup,
            'message_id'  => $response->messageId,
            'type'        => 'preview',
        ]);
    }

    /** Post approved result to channel */
    public function postResultToChannel(SignalResult $result): string
    {
        $channel = $result->signal->channel === 'vip'
            ? $this->vipChannel
            : $this->publicChannel;

        $response = Telegram::sendMessage([
            'chat_id'    => $channel,
            'text'       => $result->result_text,
            'parse_mode' => 'Markdown',
        ]);

        return $response->messageId;
    }

    /** Check if Telegram user is authorized admin */
    public function isAdmin(int $telegramUserId): bool
    {
        $ids = array_map('trim', explode(',', config('app.telegram_admin_ids', '')));
        return in_array((string) $telegramUserId, $ids);
    }
}
