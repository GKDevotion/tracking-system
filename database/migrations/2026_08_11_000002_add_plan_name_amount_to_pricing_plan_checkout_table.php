<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            // Snapshot of the plan's display name and price at the moment of
            // checkout, so the email/record stays correct even if the Plan's
            // price changes later. 'plan' itself stores the Plan's id.
            $table->string('plan_name', 100)->nullable()->after('plan');
            $table->decimal('plan_amount', 10, 2)->nullable()->after('plan_name');
        });
    }

    public function down(): void
    {
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            $table->dropColumn(['plan_name', 'plan_amount']);
        });
    }
};
