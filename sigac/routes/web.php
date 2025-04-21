<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    Auth\LoginController,
    Auth\RegisterController,
    Auth\ForgotPasswordController,
    Auth\ResetPasswordController,
    AlunoController,
    CursoController,
    ComprovanteController,
    RelatorioController,
    AdminController,
    UserController,
};

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('alunos')->group(function () {
        Route::get('/', [AlunoController::class, 'index'])
            ->name('alunos.index')
            ->middleware('can:viewAny,App\Models\Aluno');
        Route::get('/create', [AlunoController::class, 'create'])
            ->name('alunos.create')
            ->middleware('can:create,App\Models\Aluno');
        Route::get('/{id}', [AlunoController::class, 'show'])
            ->name('alunos.show')
            ->middleware('can:view,aluno');
        Route::get('/{id}/edit', [AlunoController::class, 'edit'])
            ->name('alunos.edit')
            ->middleware('can:update,aluno');
        Route::get('/export', [AlunoController::class, 'export'])->name('alunos.export');
    });

    Route::prefix('cursos')->group(function () {
        Route::get('/', [CursoController::class, 'index'])->name('cursos.index');
        Route::get('/create', [CursoController::class, 'create'])->name('cursos.create');
        Route::get('/{id}', [CursoController::class, 'show'])->name('cursos.show');
        Route::get('/{id}/edit', [CursoController::class, 'edit'])->name('cursos.edit');
    });

    Route::prefix('comprovantes')->group(function () {
        Route::get('/', [ComprovanteController::class, 'index'])->name('comprovantes.index');
        Route::get('/create', [ComprovanteController::class, 'create'])->name('comprovantes.create');
        Route::get('/{id}', [ComprovanteController::class, 'show'])->name('comprovantes.show');
        Route::get('/{id}/upload', [ComprovanteController::class, 'showUploadForm'])->name('comprovantes.upload');
    });

    Route::prefix('relatorios')->group(function () {
        Route::get('/horas-alunos', [RelatorioController::class, 'horasPorAluno'])->name('relatorios.horas-alunos');
        Route::get('/horas-cursos', [RelatorioController::class, 'horasPorCurso'])->name('relatorios.horas-cursos');
    });

    Route::prefix('admin')->middleware('can:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
