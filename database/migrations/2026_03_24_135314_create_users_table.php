<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('no_telpon', 20);
            $table->enum('role', ['super-admin', 'admin', 'peminjam'])->default('peminjam');

            $table->string('nama')->nullable();
            $table->string('kelas')->nullable();
            $table->string('nipd')->nullable()->unique();
            $table->string('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();

            $table->integer('points')->nullable();
            $table->enum('tier', ['Paragon', 'Exemplar', 'Sentinel', 'Steward', 'Reliant', 'Negligent'])->nullable();
            $table->boolean('is_banned')->default(false);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
