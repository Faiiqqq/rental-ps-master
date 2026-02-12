<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogActivity extends Model
{
    protected $guarded = [];

    // Helper function biar nulisnya pendek di Controller
    public static function record($aksi, $deskripsi)
    {
        self::create([
            'id_user' => Auth::id(),
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
            'ip_address' => request()->ip(),
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}