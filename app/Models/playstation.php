<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class Playstation extends Model
{
    protected $primaryKey = 'id_ps';

    protected $fillable = [
        'tipe',
        'hargaPerJam',
        'stok',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_ps');
    }
}
