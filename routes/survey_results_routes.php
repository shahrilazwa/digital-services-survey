<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyResultsController;

Route::resource('survey-results', SurveyResultsController::class);
Route::get('survey-results/{id}/view', [SurveyResultsController::class, 'view'])->name('survey-results.view');
Route::get('survey-results/{id}/table-view', [SurveyResultsController::class, 'tableView'])->name('survey-results.table-view');