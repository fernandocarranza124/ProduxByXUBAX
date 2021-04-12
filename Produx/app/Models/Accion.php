<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    use HasFactory;
    public $timestamps = TRUE;
    protected $table = "acciones";

    protected $fillable = [
        'device_id',
        'tipo',
    ];
}
