<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // TRIGGER STOK
    public function up(): void
    {
        DB::unprepared("
        CREATE TRIGGER kurangi_stok_ps
        AFTER UPDATE ON transaksis
        FOR EACH ROW
        BEGIN
            IF NEW.status = 'main' AND OLD.status != 'main' THEN
                UPDATE playstations
                SET stok = stok - 1
                WHERE id_ps = NEW.id_ps;
            END IF;
        END
    ");

        DB::unprepared("
        CREATE TRIGGER tambah_stok_ps
        AFTER UPDATE ON transaksis
        FOR EACH ROW
        BEGIN
            IF NEW.status = 'selesai' AND OLD.status != 'selesai' THEN
                UPDATE playstations
                SET stok = stok + 1
                WHERE id_ps = NEW.id_ps;
            END IF;
        END
    ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS kurangi_stok_ps");
        DB::unprepared("DROP TRIGGER IF EXISTS tambah_stok_ps");
    }
};
