<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';

    protected $fillable = [
        'users_id',
        'gedung_id',
        'ruang_id',
        'kamera_id',
        'waktu_masuk',
        'waktu_keluar',
        'keterangan',
    ];
}
