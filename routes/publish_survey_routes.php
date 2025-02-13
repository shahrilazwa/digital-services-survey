<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublishSurveyController;

Route::resource('publish-surveys', PublishSurveyController::class);
Route::get('publish-surveys/{publish_survey}/select-schema', [PublishSurveyController::class, 'selectSchema'])->name('publish-surveys.selectSchema');
Route::put('publish-surveys/{publish_survey}/store-schema', [PublishSurveyController::class, 'storeSchema'])->name('publish-surveys.storeSchema');
Route::get('publish-surveys/{publish_survey}/select-app', [PublishSurveyController::class, 'selectApp'])->name('publish-surveys.selectApp');
Route::post('publish-surveys/{publish_survey}/store-app', [PublishSurveyController::class, 'storeApp'])->name('publish-surveys.storeApp');
Route::get('publish-surveys/{publish_survey}/select-service', [PublishSurveyController::class, 'selectService'])->name('publish-surveys.selectService');
Route::put('publish-surveys/{publish_survey}/store-service', [PublishSurveyController::class, 'storeService'])->name('publish-surveys.storeService');
Route::get('publish-surveys/{publish_survey}/select-team', [PublishSurveyController::class, 'selectTeam'])->name('publish-surveys.selectTeam');
Route::post('publish-surveys/{publish_survey}/select-team/add', [PublishSurveyController::class, 'storeTeamMember'])->name('publish-surveys.storeTeamMember');
Route::delete('publish-surveys/{publish_survey}/select-team/remove', [PublishSurveyController::class, 'removeTeamMember'])->name('publish-surveys.removeTeamMember');
Route::get('publish-surveys/{publish_survey}/publish', [PublishSurveyController::class, 'publish'])->name('publish-surveys.publish');
Route::put('publish-surveys/{publish_survey}/publish', [PublishSurveyController::class, 'storePublishSurvey'])->name('publish-surveys.storePublishSurvey');
// Route::get('publish-surveys/{publishedSurvey}', [PublishSurveyController::class, 'show'])->name('publish-surveys.show');






