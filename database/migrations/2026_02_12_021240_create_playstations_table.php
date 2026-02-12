<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('playstations', function (Blueprint $table) {
            $table->id('id_ps');
            $table->string('tipe')->unique();
            $table->integer('hargaPerJam');
            $table->integer('stok')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('playstations');
    }
};
