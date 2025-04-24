<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = [
        'curso',
        'turma',
        'user',
    ];

    function roles(){
        return $this->belongstoMany(Role::class)->withTimestamps();
    }
}
