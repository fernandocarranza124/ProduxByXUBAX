<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edad extends Model
{
    use HasFactory;
    protected $table = "edades";

    protected $fillable = [
        'nombre',
    ];
}
