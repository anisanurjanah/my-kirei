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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('payment_method_id')
                ->constrained('payment_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_id')->nullable();
            $table->string('payment_number')->unique();
            $table->timestamp('payment_date');
            $table->decimal('amount', 10, 2);
            $table->string('va_number')->nullable();
            $table->string('bank')->nullable();
            $table->string('pdf_url')->nullable();
            $table->text('qr_code_url')->nullable();
            $table->string('payment_status')->default('Ditunda');
            $table->timestamp('expiry_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
