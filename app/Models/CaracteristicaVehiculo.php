<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracteristicaVehiculo extends Model
{
    use HasFactory;
    protected $fillable = [
        "caracteristica",
        "descripcion",
        "fecha_registro",
    ];
}
