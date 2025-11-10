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
        Schema::create('komoditis', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id_komoditi')->primary(); // bisa diisi
            $table->string('nm_komoditi');
            $table->string('ket_komoditi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komoditis');
    }
};
