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
            $table->foreignId('outlet_id');
            $table->foreignId('customer_id');
            $table->foreignId('user_id');
            $table->string('order_number')->unique();
            $table->timestamp('order_date');
            $table->decimal('sub_total');
            $table->decimal('discount')->default(0);
            $table->decimal('total_price');
            $table->enum('order_type', ['Dine In', 'Take Away']);
            $table->enum('order_status', ['Selesai', 'Dibatalkan']);
            $table->enum('payment_status', ['Lunas', 'Belum Lunas']);
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
