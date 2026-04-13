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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('slug', 100)->nullable();
            $table->string('image_path', 200);
            $table->tinyInteger('type')->default(0)->comment('0: All, 1: Home')->index();
            $table->tinyInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: Disabled, 1: Enabled')->index();
            $table->tinyInteger('is_animate_image')->default(0)->comment('0: None, 1: Yes')->nullable();
            $table->text('animate_class_name')->nullable();
            $table->tinyInteger('is_news')->default(0)->comment('0: No, 1: Yes');
            $table->tinyInteger('is_click')->default(0)->comment('0: Click Button, 1: Click Image, 2: Redirect to Register Page');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};