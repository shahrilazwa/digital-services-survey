<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::resource('roles', RoleController::class);
Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermisssionToRole'])->name('roles.give-permissions');
Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermisssionToRole']); 