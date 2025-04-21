<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AlunoController,
    CategoriaController,
    ComprovanteController,
    CursoController,
    TurmaController,
    NivelController,
    DocumentoController,
    DeclaracaoController,
    AuthController,
};

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('alunos')->name('alunos.')->group(function () {
        Route::get('/', [AlunoController::class, 'index'])->name('index')->middleware('can:viewAny,App\Models\Aluno');
        Route::post('/', [AlunoController::class, 'store'])->name('store')->middleware('can:create,App\Models\Aluno');
        Route::get('/{id}', [AlunoController::class, 'show'])->name('show')->middleware('can:view,aluno');
        Route::put('/{id}', [AlunoController::class, 'update'])->name('update')->middleware('can:update,aluno');
        Route::delete('/{id}', [AlunoController::class, 'destroy'])->name('destroy')->middleware('can:delete,aluno');
        Route::post('/{id}/restore', [AlunoController::class, 'restore'])->name('restore')->middleware('can:restore,aluno');
        Route::get('/search', [AlunoController::class, 'search'])->name('search');
    });

    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('index');
        Route::post('/', [CategoriaController::class, 'store'])->name('store');
        Route::get('/{id}', [CategoriaController::class, 'show'])->name('show');
        Route::put('/{id}', [CategoriaController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [CategoriaController::class, 'restore'])->name('restore');
        Route::get('/cursos/{cursoId}/categorias', [CategoriaController::class, 'porCurso'])->name('porCurso');
    });

    Route::prefix('comprovantes')->name('comprovantes.')->group(function () {
        Route::get('/', [ComprovanteController::class, 'index'])->name('index');
        Route::post('/', [ComprovanteController::class, 'store'])->name('store');
        Route::get('/{id}', [ComprovanteController::class, 'show'])->name('show');
        Route::put('/{id}', [ComprovanteController::class, 'update'])->name('update');
        Route::delete('/{id}', [ComprovanteController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [ComprovanteController::class, 'restore'])->name('restore');
        Route::get('/alunos/{alunoId}/comprovantes', [ComprovanteController::class, 'porAluno'])->name('porAluno');
    });

    Route::prefix('cursos')->name('cursos.')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('index');
        Route::post('/', [CursoController::class, 'store'])->name('store');
        Route::get('/{id}', [CursoController::class, 'show'])->name('show');
        Route::put('/{id}', [CursoController::class, 'update'])->name('update');
        Route::delete('/{id}', [CursoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [CursoController::class, 'restore'])->name('restore');
        Route::get('/eixos/{eixoId}/cursos', [CursoController::class, 'porEixo'])->name('porEixo');
    });

    Route::prefix('turmas')->name('turmas.')->group(function () {
        Route::get('/', [TurmaController::class, 'index'])->name('index');
        Route::post('/', [TurmaController::class, 'store'])->name('store');
        Route::get('/{id}', [TurmaController::class, 'show'])->name('show');
        Route::put('/{id}', [TurmaController::class, 'update'])->name('update');
        Route::delete('/{id}', [TurmaController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [TurmaController::class, 'restore'])->name('restore');
        Route::get('/cursos/{cursoId}/turmas', [TurmaController::class, 'porCurso'])->name('porCurso');
    });

    Route::prefix('niveis')->name('niveis.')->group(function () {
        Route::get('/', [NivelController::class, 'index'])->name('index');
        Route::post('/', [NivelController::class, 'store'])->name('store');
        Route::get('/{id}', [NivelController::class, 'show'])->name('show');
        Route::put('/{id}', [NivelController::class, 'update'])->name('update');
        Route::delete('/{id}', [NivelController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [NivelController::class, 'restore'])->name('restore');
    });

    Route::prefix('documentos')->name('documentos.')->group(function () {
        Route::get('/', [DocumentoController::class, 'index'])->name('index');
        Route::post('/', [DocumentoController::class, 'store'])->name('store');
        Route::get('/{id}', [DocumentoController::class, 'show'])->name('show');
        Route::put('/{id}', [DocumentoController::class, 'update'])->name('update');
        Route::delete('/{id}', [DocumentoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [DocumentoController::class, 'restore'])->name('restore');
        Route::get('/{id}/download', [DocumentoController::class, 'download'])->name('download');
        Route::post('/{id}/aprovar', [DocumentoController::class, 'aprovar'])->name('aprovar');
        Route::post('/{id}/reprovar', [DocumentoController::class, 'reprovar'])->name('reprovar');
    });

    Route::prefix('declaracoes')->name('declaracoes.')->group(function () {
        Route::get('/', [DeclaracaoController::class, 'index'])->name('index');
        Route::post('/', [DeclaracaoController::class, 'store'])->name('store');
        Route::get('/{id}', [DeclaracaoController::class, 'show'])->name('show');
        Route::put('/{id}', [DeclaracaoController::class, 'update'])->name('update');
        Route::delete('/{id}', [DeclaracaoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [DeclaracaoController::class, 'restore'])->name('restore');
        Route::get('/search', [DeclaracaoController::class, 'search'])->name('search');
    });
});

Route::get('/health', fn() => response()->json(['status' => 'ok']))->name('health');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:api');
});