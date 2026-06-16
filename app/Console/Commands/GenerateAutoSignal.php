<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AutoSignalService;
use Illuminate\Support\Facades\Log;

class GenerateAutoSignal extends Command
{
    protected $signature   = 'wealthora:auto-signal';
    protected $description = 'Generate an automatic signal from real market price, with a random fire chance';

    public function handle(AutoSignalService $service): void
    {
        if (!config('services.auto_signal.enabled')) {
            $this->info('Auto-signal is disabled. Set AUTO_SIGNAL_ENABLED=true in .env.');
            return;
        }

        Log::channel('telegram')->info('⏰ AUTO-SIGNAL CRON FIRED');

        $signal = $service->maybeGenerate();

        if ($signal) {
            $this->info("✅ Auto-signal #{$signal->id} created and sent for approval: {$signal->pair} {$signal->direction}");
        } else {
            $this->info('⏭️ Skipped this run (random chance or no price data).');
        }
    }
}
