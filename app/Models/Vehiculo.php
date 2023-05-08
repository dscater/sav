<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        "marca_id",
        "tipo_id",
        "anio_id",
        "modelo_id",
        "descripcion",
        "imagen",
        "fecha_registro",
    ];

    protected $appends = ["url_imagen", "full_name"];

    public function getFullNameAttribute()
    {
        return $this->marca->marca . ' | ' . $this->tipo->tipo . " | " . $this->anio->anio . " | " . $this->modelo->modelo;
    }

    public function getUrlImagenAttribute()
    {
        $base_url = asset("imgs/vehiculos/");
        if ($this->imagen != NULL) {
            return $base_url . "/" . $this->imagen;
        }
        return $base_url . "/default.png";
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, "marca_id");
    }
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, "tipo_id");
    }

    public function anio()
    {
        return $this->belongsTo(Anio::class, "anio_id");
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, "modelo_id");
    }
}
