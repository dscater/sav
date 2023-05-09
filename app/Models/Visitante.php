<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Visitante extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        "nombre",
        "correo",
        "user_id",
        "estado",
        "fecha_registro",
    ];

    protected $appends = ['path_image'];

    public function getPathImageAttribute()
    {
        return asset('imgs/users/default.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
