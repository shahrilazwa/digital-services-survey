<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;

Route::resource('organizations', OrganizationController::class);
Route::get('organizations/{organizationId}/delete', [OrganizationController::class, 'destroy']);