<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Aluno;

class Comprovante extends Model
{
    protected $table = 'comprovantes';
    protected $fillable = [
        'categoria',
    ];

    function roles(){
        return $this->belongsTo(Aluno::class)->withTimestamps();
    }
}
