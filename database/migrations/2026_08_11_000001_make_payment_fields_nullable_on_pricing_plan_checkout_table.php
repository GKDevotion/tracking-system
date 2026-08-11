<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Requires doctrine/dbal for ->change(). If you don't have it:
        //   composer require doctrine/dbal
        // Alternatively, skip this file and run the raw SQL block below directly.
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->change();
            $table->integer('payment_option')->nullable()->change();
            $table->string('confirm_payment')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            $table->string('payment_type')->nullable(false)->change();
            $table->integer('payment_option')->nullable(false)->change();
            $table->string('confirm_payment')->nullable(false)->change();
        });
    }
};

/*
|--------------------------------------------------------------------------
| No doctrine/dbal? Run this raw SQL instead of this migration (adjust
| the column types if your originals differ, e.g. ENUM instead of VARCHAR):
|--------------------------------------------------------------------------

ALTER TABLE pricing_plan_checkout
    MODIFY payment_type VARCHAR(255) NULL,
    MODIFY payment_option INT NULL,
    MODIFY confirm_payment VARCHAR(255) NULL;

*/
