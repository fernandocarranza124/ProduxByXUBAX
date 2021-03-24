<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    protected $fillable = [
        'Nombre'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
