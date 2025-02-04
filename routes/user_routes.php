<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::resource('users', UserController::class);
Route::get('users/{userId}/delete', [UserController::class, 'destroy']);