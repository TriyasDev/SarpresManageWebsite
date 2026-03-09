<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_user', function (Blueprint $table) {
            $table->string('nipd')->nullable()->unique()->after('username');
            $table->string('alamat')->nullable()->after('nipd');
            $table->date('tanggal_lahir')->nullable()->after('alamat');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable()->after('tanggal_lahir');
        });
    }

    public function down(): void
    {
        Schema::table('tb_user', function (Blueprint $table) {
            $table->dropColumn(['nipd', 'alamat', 'tanggal_lahir', 'jenis_kelamin']);
        });
    }
};
