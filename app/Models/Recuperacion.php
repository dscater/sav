<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recuperacion extends Model
{
    use HasFactory;
    protected $fillable = [
        "registro_id",
        "correo",
        "estado",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'registro_id');
    }

    public function visitante()
    {
        return $this->belongsTo(Visitante::class, 'registro_id');
    }
}
