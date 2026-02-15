<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Integer;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 50)->unique;
            $table->string('password');
            $table->string('email', 100)->unique;
            $table->string('no_telpon', 20);
            $table->enum('role', ['admin', 'peminjam']);
            $table->enum('rank', ['Paragon', 'Exempalar', 'Sentinel', 'Steward', 'Reliant', 'Negligent'])->nullable();
            $table->integer('point')->nullable()->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tb_user');
    }
};
