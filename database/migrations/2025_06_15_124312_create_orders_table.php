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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->decimal('total_price', 10, 2);
            $table->unsignedInteger('total_item')->default(0);
            $table->unsignedBigInteger('cashier_id')->nullable();
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('set null');
            $table->string('payment_method')->default('cash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
