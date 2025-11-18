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
        Schema::table('budidayas', function (Blueprint $table) {
            // Ubah id_budidaya menjadi auto increment
            $table->unsignedBigInteger('id_budidaya')->autoIncrement()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budidayas', function (Blueprint $table) {
            // Kembalikan ke non-auto increment
            $table->unsignedBigInteger('id_budidaya')->change();
        });
    }
};
