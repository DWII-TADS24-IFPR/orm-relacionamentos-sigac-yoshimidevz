<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Nivel extends Model
{
    protected $table = 'niveis';
    protected $fillable = [
        'nome',
        'categoria_id',
    ];

    function roles(){
        return $this->belongstoMany(Role::class)->withTimestamps();
    }
}
