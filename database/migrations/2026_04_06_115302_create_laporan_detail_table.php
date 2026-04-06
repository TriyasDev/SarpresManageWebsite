<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    { 
        Schema::create('tb_laporan_detail', function (Blueprint $table) {
            $table->id('id_laporan_detail');
            $table->unsignedBigInteger('id_laporan');
            $table->unsignedBigInteger('id_barang');
            $table->integer('jumlah_dikembalikan')->default(0);
            $table->timestamps();

            $table->foreign('id_laporan')->references('id_laporan')->on('tb_laporan')->onDelete('cascade');
            $table->foreign('id_barang')->references('id_barang')->on('tb_barang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_laporan_detail');
    }
};
