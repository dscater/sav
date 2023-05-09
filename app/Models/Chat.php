<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        "visitante_id",
        "emisor_id",
        "receptor_id",
        "mensaje",
        "fecha",
        "hora",
        "estado",
    ];

    protected $appends = ["fecha_chat"];

    public function getFechaChatAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function visitante()
    {
        return $this->belongsTo(Visitante::class, 'visitante_id');
    }

    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }
    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }
}
