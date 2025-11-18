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
        Schema::create('mst_fasemonitors', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id_monitor')->primary();

            // $table->string('nm_monitor', 100)->nullable();
            $table->string('grub_fasemonitor');
            $table->string('fase_monitoring');
            $table->string('parameter');
            $table->string('titik_kritis');
            $table->string('monitoring_poin');
            $table->string('bobot');
            $table->string('keterangan');
            // $table->string('field1');
            // $table->string('field2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_fasemonitors');
    }
};
