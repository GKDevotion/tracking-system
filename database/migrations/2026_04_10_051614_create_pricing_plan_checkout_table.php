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
        Schema::create('pricing_plan_checkout', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->tinyInteger('plan')->comment('0:Basic plan, 1:Advance Trader, 2: Institutional Trader');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->string('email');
            $table->string('country');
            $table->tinyInteger('trade_signals')->comment('0:telegram, 1:whatsapp');
            $table->string('tele_username')->nullable();
            $table->string('mobile_number');
            $table->tinyInteger('payment_option')->nullable()->comment('0:USDT-Tether, 1:USDT-BEP20');
            $table->string('confirm_payment')->nullable(); // file path
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plan_checkout');
    }
};
