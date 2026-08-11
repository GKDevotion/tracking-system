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
            //
              $table->unsignedBigInteger('country_id')
                ->nullable()
                ->after('email');

            $table->dropColumn('country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_plan_checkout', function (Blueprint $table) {
            //
             $table->string('country')->nullable()->after('email');

            $table->dropColumn('country_id');
        });
    }
};
