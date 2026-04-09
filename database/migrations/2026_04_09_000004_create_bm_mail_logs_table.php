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
        Schema::create('bm_mail_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('bm_clients')->cascadeOnDelete();
            $table->foreignId('template_id')->constrained('bm_mail_templates')->cascadeOnDelete();
            $table->string('email_sent_to', 180);
            $table->string('subject', 255);
            $table->enum('status', ['sent', 'failed'])->default('failed');
            $table->text('response')->nullable();        // success msg or error
            $table->boolean('is_bulk')->default(false);
            $table->string('campaign_id', 36)->nullable(); // UUID per bulk batch
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bm_mail_logs');
    }
};
