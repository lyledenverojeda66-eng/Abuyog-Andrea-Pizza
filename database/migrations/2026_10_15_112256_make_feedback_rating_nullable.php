<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        // Keep rating nullable to avoid losing concern records
        // that do not have a rating.
    }
};