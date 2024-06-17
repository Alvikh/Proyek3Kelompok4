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

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }
}
