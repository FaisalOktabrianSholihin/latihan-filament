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
        Schema::table('monitor_tcs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kriteria')->nullable();
            $table->foreign('id_kriteria')->references('id_kriteria')->on('kriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitor_tcs', function (Blueprint $table) {
            $table->dropForeign(['id_kriteria']);
            $table->dropColumn('id_kriteria');
        });
    }
};
