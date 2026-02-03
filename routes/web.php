<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [UserController::class, 'viewRegister'])->name('view.register');
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::get('/login', [UserController::class, 'viewLogin'])->name('view.login');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'viewProfile'])->name('view.profile');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/settings', [UserController::class, 'viewSettings'])->name('view.settings');
    Route::put('/settings/user/update/{id}', [UserController::class, 'update'])->name('update.user');
});
