<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLoggedIn;
use App\Http\Middleware\CheckIsNotLoggedIn;
use Illuminate\Support\Facades\Route;

// Rota de login e registro para usuários não logados
Route::middleware([CheckIsNotLoggedIn::class])->group(function () {
  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);
  
  Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
  Route::post('/registerSubmit', [RegisterController::class, 'registerSubmit'])->name('register.submit');
});

// Rota para usuários logados
Route::middleware([CheckIsLoggedIn::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');

    // Outras rotas para notas
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::post('/editNoteSubmit/{id}', [MainController::class, 'editNoteSubmit'])->name('editNoteSubmit');
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');
    Route::get('/deleteNoteConfirm/{id}', [MainController::class, 'deleteNoteConfirm'])->name('deleteConfirm');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
