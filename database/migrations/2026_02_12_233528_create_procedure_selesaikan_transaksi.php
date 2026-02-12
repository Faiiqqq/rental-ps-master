<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // STORE PROCEDURE UNTUK SELESAIKAN_TRANSAKSI
        DB::unprepared("
            DROP PROCEDURE IF EXISTS selesaikan_transaksi;
            CREATE PROCEDURE selesaikan_transaksi(IN input_id_transaksi INT)
            BEGIN
                -- 1. Update status transaksi dan waktu selesai
                UPDATE transaksis 
                SET status = 'selesai', 
                    jam_selesai = NOW() 
                WHERE id_transaksi = input_id_transaksi;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS selesaikan_transaksi");
    }
};
