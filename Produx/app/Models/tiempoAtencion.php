<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tiempoAtencion extends Model
{
    use HasFactory;
    protected $table="tiempos_emociones";
        public $timestamps = TRUE;

    protected $fillable = [
        'persona_id',
        'emocion_id',
        'role',
    ];
}
