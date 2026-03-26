<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_point_logs', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_peminjaman')->nullable();
            $table->integer('change');
            $table->string('reason');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('tb_peminjaman')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_point_logs');
    }
};
