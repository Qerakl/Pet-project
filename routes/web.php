<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'feed'])->name('feed');

require __DIR__.'/web/auth.php';
require __DIR__.'/web/post.php';
