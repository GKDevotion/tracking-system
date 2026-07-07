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
            if (!Schema::hasColumn('free_signals_updates', 'result_id')) {
                $table->unsignedBigInteger('result_id')
                      ->nullable()
                      ->after('post_id');
            }

            if (!Schema::hasColumn('free_signals_updates', 'result_date')) {
                $table->date('result_date')
                      ->nullable()
                      ->after('result_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_signals_updates', function (Blueprint $table) {
            if (Schema::hasColumn('free_signals_updates', 'result_date')) {
                $table->dropColumn('result_date');
            }

            if (Schema::hasColumn('free_signals_updates', 'result_id')) {
                $table->dropColumn('result_id');
            }
        });
    }
};
