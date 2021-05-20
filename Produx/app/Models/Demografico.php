<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demografico extends Model
{
    use HasFactory;
    protected $table = "demograficos";

    protected $fillable = [
        'id',
        'categoria_id',
        'accion_id',
        'created_at',
        'genero_id',
        'edad_id',
        'emocion_id',
        'atencion',
        'duracionAtencion',
        'persona_id',
    ];
}
