<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    use HasFactory;
    protected $table = 'ruang';

    protected $fillable = ['nama_ruang', 'gedung_id'];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class);
    }
}
