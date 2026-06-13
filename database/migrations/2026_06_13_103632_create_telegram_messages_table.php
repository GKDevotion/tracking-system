<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('telegram_messages', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type');             // signal | result
            $table->unsignedBigInteger('entity_id');
            $table->string('chat_id');                 // which chat/group
            $table->string('message_id');              // Telegram message ID
            $table->string('type');                    // preview | posted
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('telegram_messages'); }
};
