<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
        public $timestamps = TRUE;

    protected $fillable = [
        'estado',
        'nombre',
        'categoria',
        'pin',
        'upc',
        'user_id',
    ];
}
