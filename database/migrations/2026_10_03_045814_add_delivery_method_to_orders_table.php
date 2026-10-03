<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('delivery_method', [
                'delivery',
                'pickup',
            ])
            ->default('delivery')
            ->after('contact_number');
        });

        DB::statement("
            ALTER TABLE orders
            MODIFY payment_method ENUM(
                'cash_on_delivery',
                'cash',
                'gcash'
            )
            DEFAULT 'cash_on_delivery'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE orders
            MODIFY payment_method ENUM(
                'cash_on_delivery',
                'gcash'
            )
            DEFAULT 'cash_on_delivery'
        ");

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('delivery_method');
        });
    }
};