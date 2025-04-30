<?php

use App\Http\Controllers\NivelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['idade' => 17], ['frutas' => ['banana', 'maçã', 'laranja']]);
});

Route::resources('/niveis',[NivelController::class]);
