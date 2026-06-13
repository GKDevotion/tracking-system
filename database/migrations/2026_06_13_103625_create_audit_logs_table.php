<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');                  // approved, rejected, posted
            $table->string('entity_type');             // signal, signal_result
            $table->unsignedBigInteger('entity_id');
            $table->string('performed_by');            // Telegram user ID
            $table->string('performed_by_name')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('audit_logs'); }
};
