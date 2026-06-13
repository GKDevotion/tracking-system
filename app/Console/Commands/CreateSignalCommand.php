<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Signal;
use App\Services\MessageFormatterService;
use App\Services\TelegramService;

class CreateSignalCommand extends Command
{
    protected $signature   = 'wealthora:signal';
    protected $description = 'Create and submit a signal to Telegram approval';

    public function handle(MessageFormatterService $formatter, TelegramService $telegram): void
    {
        $pair      = $this->ask('Pair (e.g. GBP/USD)');
        $direction = strtoupper($this->choice('Direction', ['BUY','SELL']));
        $entryMin  = $this->ask('Entry min');
        $entryMax  = $this->ask('Entry max (or blank)');
        $sl        = $this->ask('SL');
        $tp1       = $this->ask('TP1');
        $tp2       = $this->ask('TP2');
        $tp3       = $this->ask('TP3');
        $channel   = $this->choice('Channel', ['public','vip'], 0);

        $signal = Signal::create([
            'pair'      => $pair,
            'direction' => $direction,
            'entry_min' => $entryMin,
            'entry_max' => $entryMax ?: null,
            'sl'        => $sl,
            'tp1'       => $tp1 ?: null,
            'tp2'       => $tp2 ?: null,
            'tp3'       => $tp3 ?: null,
            'channel'   => $channel,
            'status'    => 'draft',
        ]);

        $signal->update(['signal_text' => $formatter->formatSignal($signal)]);
        $signal->update(['status' => 'pending_approval']);
        $telegram->sendSignalPreview($signal);

        $this->info("✅ Signal #{$signal->id} sent to Approval Desk!");
    }
}
