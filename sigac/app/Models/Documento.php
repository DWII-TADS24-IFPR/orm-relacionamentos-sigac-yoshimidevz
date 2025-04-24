<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Documento extends Model
{
    protected $table = 'documentos';
    protected $fillable = [
        'arquivo',
        'descricao',
        'categoria_id',
        'user_id',
    ];

    function roles(){
        return $this->belongstoMany(Role::class)->withTimestamps();
    }
}
