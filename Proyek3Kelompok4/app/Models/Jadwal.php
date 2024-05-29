<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = ['id', 'nama_hari', 'status', 'waktu_masuk', 'waktu_keluar'];

    use HasFactory;
}
