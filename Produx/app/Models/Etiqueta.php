<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;
    public $timestamps = TRUE;

    protected $fillable = [
        'nombre',
        'user_id',
        'color',
    ];
}
