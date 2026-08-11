<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_private_signal_updates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('signal_id')
                ->nullable()
                ->constrained('telegram_private_signals')
                ->nullOnDelete();

            $table->unsignedBigInteger('channel_id');

            $table->unsignedBigInteger('telegram_message_id');

            $table->unsignedBigInteger('reply_to_message_id')
                ->nullable();

            $table->string('update_type', 30);

            $table->decimal('result_pips', 15, 2)
                ->nullable();

            $table->text('message')
                ->nullable();

            $table->longText('raw_payload')
                ->nullable();

            $table->timestamp('telegram_date')
                ->nullable();

            $table->timestamps();

            $table->unique(
                ['channel_id', 'telegram_message_id'],
                'telegram_update_unique'
            );

            $table->index('reply_to_message_id');
            $table->index('update_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_private_signal_updates');
    }
};
