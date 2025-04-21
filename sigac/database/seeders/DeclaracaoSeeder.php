<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclaracoesTable extends Migration
{
    public function up()
    {
        Schema::create('declaracoes', function (Blueprint $table) {
            $table->id();
            $table->string('hash', 64)->unique();
            $table->dateTime('data');
            $table->foreignId('aluno_id')
                  ->constrained('alunos')
                  ->onDelete('cascade');
            $table->foreignId('comprovante_id')
                  ->constrained('comprovantes')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index('hash');
            $table->index('aluno_id');
            $table->index('comprovante_id');
        });
    }

    public function down()
    {
        Schema::table('declaracoes', function (Blueprint $table) {
            $table->dropForeign(['aluno_id']);
            $table->dropForeign(['comprovante_id']);
        });
        
        Schema::dropIfExists('declaracoes');
    }
}