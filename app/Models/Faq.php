<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        "vehiculo_id",
        "caracteristica_id",
        "pregunta",
        "respuesta",
        "fecha_registro",
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function caracteristica_vehiculo()
    {
        return $this->belongsTo(CaracteristicaVehiculo::class, 'caracteristica_id');
    }
}
