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
            $table->text('take_profit')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_signals_updates', function (Blueprint $table) {
            //
            $table->decimal('take_profit', 15, 4)->nullable()->change();
        });
    }
};
