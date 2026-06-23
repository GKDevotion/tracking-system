<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mt5_trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('signal_id')->constrained()->onDelete('cascade');
            $table->string('ticket')->nullable();       // MT5 order ticket number
            $table->string('pair');
            $table->enum('direction', ['BUY', 'SELL']);
            $table->decimal('lots', 8, 2)->default(0.01);
            $table->decimal('entry', 12, 5);
            $table->decimal('sl', 12, 5)->nullable();
            $table->decimal('tp1', 12, 5)->nullable();
            $table->enum('status', ['open','closed','failed'])->default('open');
            $table->text('raw_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('mt5_trades'); }
};
