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
        Schema::create('monitor_tcs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_monitor_tc')->primary();
            $table->string('nilai_monitor');
            $table->string('ket_monitor');
            $table->date('tgl_monitoring');
            $table->date('tgl_update');
            $table->string('evalusi_monitoring');
            $table->string('hasil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitor_tcs');
    }
};
