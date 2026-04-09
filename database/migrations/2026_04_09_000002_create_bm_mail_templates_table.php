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
        Schema::create('bm_mail_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()
                  ->constrained('bm_categories')->nullOnDelete();
            $table->string('name', 150);
            $table->string('slug', 170)->unique();
            $table->string('subject', 255);
            $table->string('short_description', 350)->nullable();
            $table->longText('mail_template');          // HTML body
            $table->tinyInteger('status')->default(1)->comment('0:Disabled 1:Enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bm_mail_templates');
    }
};
