<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;

class Turma extends Model
{
    protected $table = 'turmas';
    protected $fillable = [
        'curso_id',
        'ano',
    ];

    function roles(){
        return $this->hasOne(Curso::class)->withTimestamps();
    }
}
