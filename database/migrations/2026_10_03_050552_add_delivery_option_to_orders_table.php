<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('delivery_option', [
                'delivery',
                'pickup',
            ])
            ->default('delivery')
            ->after('delivery_fee');

            $table->string('payment_method', 30)
                ->default('cash_on_delivery')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_option');

            $table->enum('payment_method', [
                'cash_on_delivery',
                'gcash',
            ])
            ->default('cash_on_delivery')
            ->change();
        });
    }
};