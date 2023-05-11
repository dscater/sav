<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistaFecha extends Model
{
    use HasFactory;
    protected $fillable = [
        "faq_id",
        "vistas",
        "fecha",
    ];

    public function faq()
    {
        return $this->belongsTo(Faq::class, "faq_id");
    }
}
