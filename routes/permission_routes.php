<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

Route::resource('permissions', PermissionController::class);
Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);