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
        Schema::table('tcs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_komoditi')->nullable();
            $table->foreign('id_komoditi')->references('id_komoditi')->on('komoditis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tcs', function (Blueprint $table) {
            $table->dropForeign(['id_komoditi']);
            $table->dropColumn('id_komoditi');
        });
    }
};
