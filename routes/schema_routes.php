<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchemaController;

Route::get('schemas/{schemaId}/delete', [SchemaController::class, 'destroy'])->name('schemas.delete');

Route::get('schemas/{schema}/design', [SchemaController::class, 'createSchema'])->name('schemas.createSchema');
Route::post('schemas/{schema}/design', [SchemaController::class, 'storeSchema'])->name('schemas.storeSchema');
Route::get('schemas/{schema}/creator', [SchemaController::class, 'showCreator'])->name('schemas.creator');

Route::get('schemas/{schema}/team', [SchemaController::class, 'createTeam'])->name('schemas.createTeam');
Route::post('schemas/{schema}/team/add', [SchemaController::class, 'storeTeamMember'])->name('schemas.storeTeamMember');
Route::delete('schemas/{schema}/team/remove', [SchemaController::class, 'removeTeamMember'])->name('schemas.removeTeamMember');
Route::post('schemas/{schema}/team/update', [SchemaController::class, 'updateTeam'])->name('schemas.updateTeam');

Route::get('schemas/{schema}/preview', [SchemaController::class, 'previewSchema'])->name('schemas.previewSchema');
Route::post('schemas/{schema}/update-step', [SchemaController::class, 'updateStep'])->name('schemas.updateStep');


Route::get('schemas/{schema}/data', [SchemaController::class, 'getSurveyData'])->name('schemas.getData');
Route::resource('schemas', SchemaController::class);