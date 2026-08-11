<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telegram_private_signals', function (Blueprint $table) {
            $table->unique(
                ['channel_id', 'telegram_message_id'],
                'telegram_channel_message_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('telegram_private_signals', function (Blueprint $table) {
            $table->dropUnique('telegram_channel_message_unique');
        });
    }
};
