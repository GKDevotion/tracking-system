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
        Schema::table('free_signals_updates', function (Blueprint $table) {
            //
            $table->tinyInteger('mt5_status')->default(0)->after('result_date');
            // 0 Pending
            // 1 Sent
            // 2 Executed
            // 3 Closed
            // 4 Failed

            $table->bigInteger('ticket')->nullable();

            $table->decimal('executed_price',15,5)->nullable();

            $table->timestamp('sent_at')->nullable();

            $table->timestamp('executed_at')->nullable();

            $table->timestamp('closed_at')->nullable();

            $table->text('mt5_response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_signals_updates', function (Blueprint $table) {
            //
        });
    }
};
