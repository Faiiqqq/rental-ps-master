<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared("
        DROP FUNCTION IF EXISTS hitung_total_denda;
        CREATE FUNCTION hitung_total_denda(input_id_transaksi INT) RETURNS INT
        DETERMINISTIC
        BEGIN
            DECLARE v_batas_kembali DATETIME;
            DECLARE v_denda_per_jam INT DEFAULT 2000;
            DECLARE v_telat_menit INT;
            DECLARE v_hasil_denda INT DEFAULT 0;

            -- Ambil batas_kembali
            SELECT batas_kembali INTO v_batas_kembali 
            FROM transaksis 
            WHERE id_transaksi = input_id_transaksi;

            -- Hitung selisih dalam MENIT
            SET v_telat_menit = TIMESTAMPDIFF(MINUTE, v_batas_kembali, NOW());

            -- Jika telat > 0 menit, hitung denda
            -- Kita gunakan pembulatan ke atas (CEIL) agar 1 menit telat tetap dihitung 1 jam
            IF v_telat_menit > 0 THEN
                SET v_hasil_denda = CEIL(v_telat_menit / 60) * v_denda_per_jam;
            END IF;

            RETURN v_hasil_denda;
        END
    ");
    }

    public function down(): void
    {
        DB::unprepared("DROP FUNCTION IF EXISTS hitung_total_denda");
    }
};
