<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Playstation;
use App\Models\User;

class Transaksi extends Model
{
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_ps',
        'id_user',
        'jam_mulai',
        'batas_kembali',
        'jam_selesai',
        'lama_jam',
        'total_bayar',
        'status',
        'denda'
    ];
    protected $casts = [
        'jam_mulai' => 'datetime',
        'batas_kembali' => 'datetime',
        'jam_selesai' => 'datetime',
    ];


    public function playstation()
    {
        return $this->belongsTo(Playstation::class, 'id_ps');
    }

    public function pelanggan()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
