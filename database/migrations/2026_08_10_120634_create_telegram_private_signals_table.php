<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telegram_private_signals', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('channel_id');
            $table->bigInteger('telegram_message_id');

            $table->string('symbol');
            $table->enum('direction', ['BUY', 'SELL']);

            $table->decimal('entry', 15, 5)->nullable();
            $table->decimal('stop_loss', 15, 5)->nullable();

            $table->decimal('take_profit_1', 15, 5)->nullable();
            $table->decimal('take_profit_2', 15, 5)->nullable();

            $table->text('raw_message')->nullable();

            $table->timestamps();

            $table->unique([
                'channel_id',
                'telegram_message_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_private_signals');
    }
};
