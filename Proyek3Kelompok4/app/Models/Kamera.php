<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamera extends Model
{
    use HasFactory;
    protected $table = 'kamera';

    protected $fillable = [
        'gedung_id',
        'ruang_id',
        'nama_kamera',
        'sumber',
        'status',
    ];
}
