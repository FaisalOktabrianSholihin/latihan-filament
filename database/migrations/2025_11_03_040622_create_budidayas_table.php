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
        Schema::create('budidayas', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id_budidaya')->primary();
            $table->string('id_asman_manager');
            $table->string('nm_asman_manager');
            $table->string('id_atasan')->nullable();  
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */ 
    public function down(): void
    {
        Schema::dropIfExists('budidayas');
    }
};
