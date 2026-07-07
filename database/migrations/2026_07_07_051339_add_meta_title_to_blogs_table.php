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
        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'meta_title')) {
                $table->string('meta_title', 255)
                      ->nullable()
                      ->after('title'); // Change the position if needed
            }
            if (!Schema::hasColumn('blogs', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }

            if (!Schema::hasColumn('blogs', 'h1_tag')) {
                $table->string('h1_tag')->nullable()->after('meta_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'meta_title')) {
                $table->dropColumn('meta_title');
            }

            if (Schema::hasColumn('blogs', 'meta_description')) {
                $table->dropColumn('meta_description');
            }

            if (Schema::hasColumn('blogs', 'h1_tag')) {
                $table->dropColumn('h1_tag');
            }
        });
    }
};
