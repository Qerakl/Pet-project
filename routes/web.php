<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [UserController::class, 'viewRegister'])->name('view.register');
Route::post('/register', [UserController::class, 'register'])->name('register');
