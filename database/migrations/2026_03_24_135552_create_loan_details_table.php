<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_detail_peminjaman', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah');

            $table->enum('kondisi_pinjam', ['baik', 'rusak ringan', 'rusak berat'])->nullable();
            $table->enum('kondisi_kembali', ['baik', 'rusak ringan', 'rusak berat'])->nullable();
            $table->text('keterangan')->nullable();

            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('tb_peminjaman')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('tb_barang')->onDelete('restrict');

            $table->index(['id_peminjaman', 'id_barang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_detail_peminjaman');
    }
};
