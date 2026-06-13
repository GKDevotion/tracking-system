<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signal;
use App\Models\SignalResult;
use App\Models\AuditLog;
use App\Services\TelegramService;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhookController extends Controller
{
    public function __construct(private TelegramService $telegram) {}

    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        $update = Telegram::commandsHandler(true);

        if ($update->has('callback_query')) {
            $this->handleCallbackQuery($update->getCallbackQuery());
        }

        return response()->json(['ok' => true]);
    }

    private function handleCallbackQuery($callbackQuery): void
    {
        $from   = $callbackQuery->getFrom();
        $userId = $from->getId();
        $data   = $callbackQuery->getData();
        $chatId = $callbackQuery->getMessage()->getChat()->getId();
        $msgId  = $callbackQuery->getMessage()->getMessageId();

        // Security check
        if (!$this->telegram->isAdmin($userId)) {
            Telegram::answerCallbackQuery([
                'callback_query_id' => $callbackQuery->getId(),
                'text'              => '⛔ Unauthorized. Only admins can approve.',
                'show_alert'        => true,
            ]);
            return;
        }

        [$action, $id] = explode(':', $data);

        match ($action) {
            'approve_signal' => $this->approveSignal((int)$id, $userId, $from->getFirstName(), $chatId, $msgId, $callbackQuery->getId()),
            'reject_signal'  => $this->rejectSignal((int)$id, $userId, $from->getFirstName(), $chatId, $msgId, $callbackQuery->getId()),
            'approve_result' => $this->approveResult((int)$id, $userId, $from->getFirstName(), $chatId, $msgId, $callbackQuery->getId()),
            'reject_result'  => $this->rejectResult((int)$id, $userId, $from->getFirstName(), $chatId, $msgId, $callbackQuery->getId()),
            default          => null,
        };
    }

    private function approveSignal(int $id, int $userId, string $name, $chatId, $msgId, $callbackId): void
    {
        $signal = Signal::findOrFail($id);
        $signal->update([
            'status'      => 'approved',
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);

        $telegramMsgId = $this->telegram->postSignalToChannel($signal);
        $signal->update(['status' => 'posted', 'telegram_message_id' => $telegramMsgId]);

        AuditLog::create([
            'action'            => 'approved_signal',
            'entity_type'       => 'signal',
            'entity_id'         => $id,
            'performed_by'      => $userId,
            'performed_by_name' => $name,
        ]);

        Telegram::editMessageText([
            'chat_id'    => $chatId,
            'message_id' => $msgId,
            'text'       => "✅ Signal #{$id} *APPROVED & POSTED* by {$name}",
            'parse_mode' => 'Markdown',
        ]);

        Telegram::answerCallbackQuery(['callback_query_id' => $callbackId, 'text' => '✅ Posted!']);
    }

    private function rejectSignal(int $id, int $userId, string $name, $chatId, $msgId, $callbackId): void
    {
        Signal::findOrFail($id)->update(['status' => 'rejected']);

        AuditLog::create([
            'action'            => 'rejected_signal',
            'entity_type'       => 'signal',
            'entity_id'         => $id,
            'performed_by'      => $userId,
            'performed_by_name' => $name,
        ]);

        Telegram::editMessageText([
            'chat_id'    => $chatId,
            'message_id' => $msgId,
            'text'       => "❌ Signal #{$id} *REJECTED* by {$name}",
            'parse_mode' => 'Markdown',
        ]);

        Telegram::answerCallbackQuery(['callback_query_id' => $callbackId, 'text' => '❌ Rejected.']);
    }

    private function approveResult(int $id, int $userId, string $name, $chatId, $msgId, $callbackId): void
    {
        $result = SignalResult::findOrFail($id);
        $result->update([
            'status'      => 'approved',
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);

        $telegramMsgId = $this->telegram->postResultToChannel($result);
        $result->update(['status' => 'posted', 'telegram_message_id' => $telegramMsgId]);

        AuditLog::create([
            'action'            => 'approved_result',
            'entity_type'       => 'signal_result',
            'entity_id'         => $id,
            'performed_by'      => $userId,
            'performed_by_name' => $name,
        ]);

        Telegram::editMessageText([
            'chat_id'    => $chatId,
            'message_id' => $msgId,
            'text'       => "✅ Result #{$id} *APPROVED & POSTED* by {$name}",
            'parse_mode' => 'Markdown',
        ]);

        Telegram::answerCallbackQuery(['callback_query_id' => $callbackId, 'text' => '✅ Posted!']);
    }

    private function rejectResult(int $id, int $userId, string $name, $chatId, $msgId, $callbackId): void
    {
        SignalResult::findOrFail($id)->update(['status' => 'rejected']);

        AuditLog::create([
            'action'            => 'rejected_result',
            'entity_type'       => 'signal_result',
            'entity_id'         => $id,
            'performed_by'      => $userId,
            'performed_by_name' => $name,
        ]);

        Telegram::editMessageText([
            'chat_id'    => $chatId,
            'message_id' => $msgId,
            'text'       => "❌ Result #{$id} *REJECTED* by {$name}",
            'parse_mode' => 'Markdown',
        ]);

        Telegram::answerCallbackQuery(['callback_query_id' => $callbackId, 'text' => '❌ Rejected.']);
    }
}
