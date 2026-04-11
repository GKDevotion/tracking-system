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
        Schema::create('countries', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto increment

            $table->string('sortname');
            $table->string('sort_description', 255);

            $table->string('name')->comment('Country Name');
            $table->string('symbol')->comment('Country Currency Symbol');

            $table->string('code')->default('0')->comment('Country Code');

            $table->string('image')->nullable()->comment('Country flag');
            $table->string('flag', 255)->nullable();

            $table->tinyInteger('status')
                  ->default(0)
                  ->comment('0: Deactivate, 1: Activate');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
