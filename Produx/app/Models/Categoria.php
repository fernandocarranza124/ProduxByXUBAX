<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    public $timestamps = TRUE;

    protected $fillable = [
        'Nombre',
        'user_id',
        'categoria',
        'team_id',
    ];
}
