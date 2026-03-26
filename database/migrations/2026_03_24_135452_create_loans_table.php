<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_admin')->nullable();

            $table->timestamp('tanggal_pinjam')->useCurrent();
            $table->timestamp('tanggal_kembali')->nullable();
            $table->timestamp('tanggal_kembali_aktual')->nullable();

            $table->enum('status', ['menunggu', 'disetujui', 'dipinjam', 'dikembalikan', 'ditolak'])->default('menunggu');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('disetujui_oleh')->nullable();

            $table->enum('return_condition', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->nullable();
            $table->boolean('is_late')->default(false);
            $table->integer('point_earned')->default(0);

            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('tb_user')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_user')->on('tb_user')->onDelete('set null');
            $table->foreign('disetujui_oleh')->references('id_user')->on('tb_user')->onDelete('set null');

            $table->index(['id_user', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_peminjaman');
    }
};
