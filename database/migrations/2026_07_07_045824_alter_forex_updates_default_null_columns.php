<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('free_signals_updates', function (Blueprint $table) {

            if (!Schema::hasColumn('free_signals_updates', 'signal_date')) {
                $table->date('signal_date')->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'pair')) {
                $table->string('pair', 50)->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'entry_price')) {
                $table->decimal('entry_price', 15, 4)->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'stop_loss')) {
                $table->decimal('stop_loss', 15, 4)->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'take_profit')) {
                $table->text('take_profit')->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'profit')) {
                $table->decimal('profit', 15, 4)->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'sort_order')) {
                $table->integer('sort_order')->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'live_btn_url')) {
                $table->string('live_btn_url', 191)->nullable()->default(null)->change();
            }

            if (!Schema::hasColumn('free_signals_updates', 'post_id')) {
                $table->unsignedBigInteger('post_id')->nullable()->default(null)->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('free_signals_updates', function (Blueprint $table) {
            $table->date('signal_date')->nullable(false)->default(null)->change();

            $table->string('pair', 50)->nullable(false)->default(null)->change();

            $table->decimal('entry_price', 15, 4)->nullable(false)->default(null)->change();

            $table->decimal('stop_loss', 15, 4)->nullable(false)->default(null)->change();

            $table->text('take_profit')->nullable(false)->default(null)->change();

            $table->integer('profit')->nullable(false)->default(null)->change();

            $table->integer('sort_order')->nullable(false)->default(null)->change();

            $table->string('live_btn_url', 191)->nullable(false)->default(null)->change();

            $table->unsignedBigInteger('post_id')->nullable(false)->default(null)->change();
        });
    }
};
