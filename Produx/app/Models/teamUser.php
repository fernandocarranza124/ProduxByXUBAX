<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teamUser extends Model
{
    use HasFactory;
    protected $table="team_user";
        public $timestamps = TRUE;

    protected $fillable = [
        'team_id',
        'user_id',
        'role',
    ];
}
