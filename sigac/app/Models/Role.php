<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Aluno;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'titulo',
    ];

    function alunos(){
        return $this->belongstoMany(Aluno::class)->withTimestamps();
    }
}
