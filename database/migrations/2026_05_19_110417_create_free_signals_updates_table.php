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
        Schema::create('free_signals_updates', function (Blueprint $table) {
            $table->id();

            $table->date('signal_date');

            $table->string('pair', 50);

            // 0 = Buy, 1 = Sell
            $table->integer('order_type')->default(0)
                  ->comment('0:Buy, 1:Sell');

            $table->decimal('entry_price', 15, 4);

            $table->decimal('stop_loss', 15, 4);

            $table->decimal('take_profit', 15, 4);

            $table->integer('profit')->nullable();

            $table->integer('sort_order')->nullable();

            // 0 = Deactive, 1 = Active
            $table->tinyInteger('status')->default(0)
                  ->comment('0:Deactive, 1:Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_signals_updates');
    }
};
