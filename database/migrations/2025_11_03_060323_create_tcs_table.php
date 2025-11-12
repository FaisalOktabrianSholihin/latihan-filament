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
        Schema::create('tcs', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id_tc')->primary(); // bisa diisi
            $table->string('tracecode');
            $table->date('tgl_tanam');
            $table->string('luas_tanam');
            $table->string('tdk_tc');
            $table->string('wilayah_tc');
            $table->string('jumlah_bedeng');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tcs');
    }
};
