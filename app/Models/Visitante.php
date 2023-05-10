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

    protected $appends = ['path_image', 'detalle_ultimo_mensaje'];

    public function getPathImageAttribute()
    {
        return asset('imgs/users/default.png');
    }

    public function getDetalleUltimoMensajeAttribute()
    {
        $ultimo = Chat::where("emisor_id", $this->user_id)->orderBy("created_at", "asc")->get()->last();
        if ($ultimo) {
            return  [
                "sw" => true,
                "chat" => $ultimo,
                "fecha" => $ultimo->created_at->diffForHumans(),
            ];
        }
        return [
            "sw" => false
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'visitante_id');
    }
}
