<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $fillable = ['id', 'users_id', 'gambar'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
