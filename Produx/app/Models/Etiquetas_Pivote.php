<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiquetas_Pivote extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'etiqueta_id',
    ];
    protected $table = "etiquetas_dispositivo";
}
