<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    use HasFactory;
    public $timestamps = TRUE;
    protected $fillable = [
        'pin',
        'user_id',
        'team_id',
        'active',
    ];
}
