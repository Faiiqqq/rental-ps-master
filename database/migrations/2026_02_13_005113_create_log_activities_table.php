<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('aksi');      // Contoh: "Tambah Transaksi", "Login"
            $table->text('deskripsi');   // Contoh: "Menambah transaksi baru ID #5"
            $table->string('ip_address')->nullable();
            $table->timestamps();        // created_at otomatis jadi waktu kejadian
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_activities');
    }
};
