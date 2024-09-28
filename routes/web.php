<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLogger;
use App\Http\Middleware\CheckIsNotLogger;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação para o usuário não logado
Route::middleware([CheckIsNotLogger::class])->group(function () {
     Route::get('/login', [AuthController::class, 'login']);
     Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
});

// Rotas para o usuário logado
Route::middleware([CheckIsLogger::class])->group(function () {
     Route::get('/', [MainController::class, 'index'])->name('home');
     Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
     Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
