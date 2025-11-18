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
        Schema::table('mst_fasemonitors', function (Blueprint $table) {
            // Ubah id_monitor menjadi auto increment
            $table->unsignedBigInteger('id_monitor')->autoIncrement()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_fasemonitors', function (Blueprint $table) {
            // Kembalikan ke non-auto increment
            $table->unsignedBigInteger('id_monitor')->change();
        });
    }
};
