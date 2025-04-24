<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable = [
        'nome',
        'sigla',
        'total_horas',
        'nivel_id',
        'eixo_id'
    ];

    function roles(){
        return $this->belongsTo(Turma::class)->withTimestamps();
    }
}
