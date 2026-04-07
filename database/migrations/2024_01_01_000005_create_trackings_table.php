<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->date('date');
            $table->string('vendor');
            $table->time('in_time');
            $table->time('out_time')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();

            // 🔥 Location Fields (Advanced)
            $table->string('ip')->nullable();
            $table->string('areaCode')->nullable();
            $table->string('cityName')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('countryName')->nullable();
            $table->string('regionCode')->nullable();
            $table->string('regionName')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('metroCode')->nullable();
            $table->string('isoCode')->nullable();

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();

            $table->string('address')->nullable()->comment('Reverse geocoded address');
            $table->enum('status', ['in', 'out'])->default('in');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trackings');
    }
};
