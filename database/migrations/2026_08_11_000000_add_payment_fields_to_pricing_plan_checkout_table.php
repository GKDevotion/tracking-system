<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            // Human-friendly reference shown to the user/admin, e.g. WOR11082026417
            $table->string('unique_id', 32)->unique()->nullable()->after('id');

            // Long random string used inside the payment link URL.
            // Kept separate from unique_id on purpose: unique_id is short/guessable
            // (date based) and is fine to show a human, but must NOT be usable to
            // open someone else's payment upload page.
            $table->string('payment_token', 64)->unique()->nullable()->after('unique_id');

            // pending_payment  -> step 1 done, waiting for user to submit payment proof
            // payment_submitted -> step 2 done, waiting for admin to verify
            // verified         -> admin confirmed payment
            // rejected         -> admin rejected payment proof
            // completed        -> free plan, nothing further required
            $table->string('status', 30)->default('pending_payment')->after('confirm_payment');

            $table->timestamp('payment_submitted_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            $table->dropColumn(['unique_id', 'payment_token', 'status', 'payment_submitted_at']);
        });
    }
};
