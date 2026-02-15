<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tb_laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_admin');
            $table->string('jenis_laporan', 50);
            $table->timestamp('priode_awal')->nullable();
            $table->timestamp('priode_akhir')->nullable();
            $table->string('file_laporan', 255);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_admin')->references('id_user')->on('tb_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tb_laporan');
    }
};
