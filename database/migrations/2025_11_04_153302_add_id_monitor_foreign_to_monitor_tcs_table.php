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
            $table->unsignedBigInteger('id_monitor')->nullable();
            $table->foreign('id_monitor')->references('id_monitor')->on('mst_fasemonitors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitor_tcs', function (Blueprint $table) {
            $table->dropForeign(['id_monitor']);
            $table->dropColumn('id_monitor');
        });
    }
};
