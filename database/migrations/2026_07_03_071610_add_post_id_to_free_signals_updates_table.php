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
            $table->bigInteger('post_id')->after('live_btn_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_signals_updates', function (Blueprint $table) {
            //
             $table->dropColumn('post_id');
        });
    }
};
