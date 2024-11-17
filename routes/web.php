<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLoggedIn;
// use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login']);
Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);

Route::middleware([CheckIsLoggedIn::class])->group(function() {
  Route::get('/', [MainController::class, 'index']);
  Route::get('/newNote', [MainController::class, 'newNote']);
  Route::get('/logout', [AuthController::class, 'logout']);
});
