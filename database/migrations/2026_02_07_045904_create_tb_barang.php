<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('nama_barang', 100);
            $table->string('kategori', 100);
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat']);
            $table->integer('jumlah_total');
            $table->integer('jumlah_tersedia');
            $table->text('deskripsi');
            $table->string('foto', 225);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tb_barang');
    }
};
