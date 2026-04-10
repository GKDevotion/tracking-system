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
        Schema::create('bm_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('company_name', 150);
            $table->string('email', 180)->unique();
            $table->string('mobile_number', 20)->nullable();
            $table->string('website', 255)->nullable();
            $table->text('address')->nullable();
            $table->text('response')->nullable();        // last mail result
            $table->tinyInteger('status')->default(1)->comment('0:Disabled 1:Enabled');
            $table->tinyInteger('sent')->default(0)->comment('0:No 1:Yes');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bm_clients');
    }
};
