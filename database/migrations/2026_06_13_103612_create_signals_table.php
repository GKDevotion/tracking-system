<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('signals', function (Blueprint $table) {
            $table->id();
            $table->string('pair');                    // GBP/USD, XAU/USD
            $table->enum('direction', ['BUY', 'SELL']);
            $table->decimal('entry_min', 10, 5);
            $table->decimal('entry_max', 10, 5)->nullable();
            $table->decimal('sl', 10, 5);
            $table->decimal('tp1', 10, 5)->nullable();
            $table->decimal('tp2', 10, 5)->nullable();
            $table->decimal('tp3', 10, 5)->nullable();
            $table->text('signal_text')->nullable();               // formatted Telegram message
            $table->enum('status', [
                'draft','pending_approval','approved','rejected','posted'
            ])->default('draft');
            $table->string('channel')->default('public'); // public | vip
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('telegram_message_id')->nullable(); // posted msg ID
            $table->string('screenshot_url')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('signals'); }
};
