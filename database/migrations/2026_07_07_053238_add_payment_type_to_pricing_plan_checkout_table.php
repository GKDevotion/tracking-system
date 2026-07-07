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
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            if (!Schema::hasColumn('pricing_plan_checkout', 'payment_type')) {
                $table->string('payment_type')
                      ->nullable()
                      ->after('payment_option'); // Change the position if needed
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            if (Schema::hasColumn('pricing_plan_checkout', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
        });
    }
};
