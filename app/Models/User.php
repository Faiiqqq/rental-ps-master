<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Transaksi;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // relasi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_user');
    }
}
