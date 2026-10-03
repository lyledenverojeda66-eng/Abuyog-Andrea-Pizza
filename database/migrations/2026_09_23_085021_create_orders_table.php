<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('order_number')->unique();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            $table->text('delivery_address');
            $table->string('contact_number');

            $table->enum('payment_method', [
                'cash_on_delivery',
                'gcash'
            ])->default('cash_on_delivery');

            $table->enum('status', [
                'pending',
                'confirmed',
                'preparing',
                'ready_for_delivery',
                'out_for_delivery',
                'delivered',
                'cancelled'
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};