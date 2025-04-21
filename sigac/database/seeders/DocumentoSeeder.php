<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->text('descricao');
            $table->float('horas_in');
            $table->enum('status', ['pendente', 'aprovado', 'reprovado'])->default('pendente');
            $table->text('comentario')->nullable();
            $table->float('horas_out')->nullable();
            $table->foreignId('categoria_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index('categoria_id');
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['user_id']);
        });
        
        Schema::dropIfExists('documentos');
    }
}