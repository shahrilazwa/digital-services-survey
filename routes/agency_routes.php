<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgencyController;

Route::resource('agencies', AgencyController::class);
Route::get('agencies/{agencyId}/delete', [AgencyController::class, 'destroy']);