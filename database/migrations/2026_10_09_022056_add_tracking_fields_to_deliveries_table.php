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
        Schema::table('deliveries', function (Blueprint $table) {
            $table->string('status')
                ->default('pending')
                ->after('rider_contact');

            $table->string('payment_status')
                ->default('pending')
                ->after('status');

            $table->timestamp('payment_received_at')
                ->nullable()
                ->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'payment_status',
                'payment_received_at',
            ]);
        });
    }
};