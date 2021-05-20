<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emocion extends Model
{
    use HasFactory;
    protected $table = "emociones";

    protected $fillable = [
        'nombre',
    ];
}
