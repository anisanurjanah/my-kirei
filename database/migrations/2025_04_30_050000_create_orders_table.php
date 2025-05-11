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
            $table->foreignId('outlet_id')
                ->constrained('outlets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('order_number')->unique();
            $table->timestamp('order_date');
            $table->decimal('sub_total');
            $table->decimal('discount')->default(0);
            $table->decimal('total_price');
            $table->string('order_type')->default('Ditunda');
            $table->string('order_status')->default('Ditunda');
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
