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
            $table->string('nilai_monitor')->nullable()->change();
            $table->string('ket_monitor')->nullable()->change();
            $table->string('evalusi_monitoring')->nullable()->change();
            $table->string('hasil')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitor_tcs', function (Blueprint $table) {
            $table->string('nilai_monitor')->nullable(false)->change();
            $table->string('ket_monitor')->nullable(false)->change();
            $table->string('evalusi_monitoring')->nullable(false)->change();
            $table->string('hasil')->nullable(false)->change();
        });
    }
};
