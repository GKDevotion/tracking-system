<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('telegram_private_signals', function (Blueprint $table) {

            $table->unsignedBigInteger('reply_to_message_id')
                ->nullable()
                ->after('telegram_message_id');

            $table->decimal('take_profit_3', 15, 5)
                ->nullable()
                ->after('take_profit_2');

            $table->string('status', 30)
                ->nullable()
                ->after('take_profit_3');

            $table->decimal('result_pips', 15, 2)
                ->nullable()
                ->after('status');

            $table->string('message_type', 30)
                ->nullable()
                ->after('result_pips');

            $table->longText('raw_payload')
                ->nullable()
                ->after('raw_message');

            $table->timestamp('telegram_date')
                ->nullable()
                ->after('raw_payload');

            $table->index('channel_id');
            $table->index('telegram_message_id');
            $table->index('reply_to_message_id');
            $table->index('status');
            $table->index('message_type');
        });
    }

    public function down(): void
    {
        Schema::table('telegram_private_signals', function (Blueprint $table) {

            $table->dropColumn([
                'reply_to_message_id',
                'take_profit_3',
                'status',
                'result_pips',
                'message_type',
                'raw_payload',
                'telegram_date',
            ]);
        });
    }
};
