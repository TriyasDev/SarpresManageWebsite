<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_peminjaman');
            $table->unsignedBigInteger('id_admin');

            $table->enum('jenis_laporan', ['dikembalikan', 'telat mengembalikan', 'hilang']);
            $table->enum('kondisi_barang', ['baik', 'masih di pinjam', 'rusak']);

            $table->timestamp('tanggal_dipinjam')->nullable();
            $table->timestamp('tanggal_dikembalikan')->nullable();
            $table->string('foto_bukti', 255);

            $table->timestamps();

            $table->foreign('id_admin')->references('id_user')->on('tb_user');
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('tb_peminjaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_laporan');
    }
};
