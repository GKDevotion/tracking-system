<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('signal_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('signal_id')->constrained()->onDelete('cascade');
            $table->enum('result_type', ['T1','T2','T3','SL','BE']);
            $table->decimal('pips_points', 8, 2)->nullable(); // positive or negative
            $table->text('result_text');               // formatted Telegram message
            $table->enum('status', [
                'draft','pending_approval','approved','rejected','posted'
            ])->default('draft');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('telegram_message_id')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('signal_results'); }
};
