<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Aluno;

class Declaracao extends Model
{
    protected $table = 'declaracoes';
    protected $fillable = [
        'arquivo',
    ];

    function roles(){
        return $this->belongstoMany(Aluno::class)->withTimestamps();
    }
}
