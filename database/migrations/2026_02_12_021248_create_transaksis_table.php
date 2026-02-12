<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_ps')->constrained('playstations', 'id_ps')->cascadeOnDelete(); // RELATION
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->dateTime('jam_mulai');
            $table->dateTime('batas_kembali');
            $table->dateTime('jam_selesai')->nullable();
            $table->integer('lama_jam')->nullable();
            $table->integer('total_bayar')->default(0);
            $table->enum('status', [
                'menunggu',
                'main',
                'return_req',
                'selesai',
                'ditolak',
                'batal'
            ])->default('menunggu');
            $table->integer('denda')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
