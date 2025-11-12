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
        Schema::table('kriterias', function (Blueprint $table) {
            // Ubah id_kriteria menjadi auto increment
            $table->unsignedBigInteger('id_kriteria')->autoIncrement()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriterias', function (Blueprint $table) {
            // Kembalikan ke non-auto increment
            $table->unsignedBigInteger('id_kriteria')->change();
        });
    }
};
