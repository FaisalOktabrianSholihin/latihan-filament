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
            $table->unsignedBigInteger('id_budidaya')->nullable();
            $table->foreign('id_budidaya')->references('id_budidaya')->on('budidayas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tcs', function (Blueprint $table) {
            $table->dropForeign(['id_budidaya']);
            $table->dropColumn('id_budidaya');
        });
    }
};
