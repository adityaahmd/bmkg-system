<?php
// database/migrations/xxxx_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('admin_fee', 15, 2)->default(5000);
            $table->decimal('tax', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->enum('payment_method', ['transfer', 'credit_card', 'ewallet'])->default('transfer');
            $table->enum('payment_status', ['pending', 'verified', 'failed'])->default('pending');
            $table->enum('order_status', ['new', 'processing', 'completed', 'cancelled'])->default('new');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};