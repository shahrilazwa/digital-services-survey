<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PublishSurveyController;
use App\Http\Controllers\DigitalPlatformController;

// Fetch all role names dynamically
$roles = Role::pluck('name')->implode('|');

Route::get('/', [PageController::class, 'login'])->name('login');
Route::get('/surveys/{id}', [PublishSurveyController::class, 'showSurvey'])->name('surveys.show');
Route::post('/survey-results/{id}', [PublishSurveyController::class, 'storeSurveyResult'])->name('survey-results.store');

// Authenticated users routes with dynamic roles
Route::group(['middleware' => ['role:' . $roles]], function () {
    require __DIR__.'/user_routes.php';
    require __DIR__.'/role_routes.php';
    require __DIR__.'/permission_routes.php';
    require __DIR__.'/schema_routes.php';
    require __DIR__.'/organization_routes.php';
    require __DIR__.'/agency_routes.php';
    require __DIR__.'/publish_survey_routes.php';
    require __DIR__.'/survey_results_routes.php';

    Route::resource('digital-platforms', DigitalPlatformController::class);
    Route::get('digital-platforms/{platformId}/delete', [DigitalPlatformController::class, 'destroy']);
    Route::resource('digital-services', ServiceController::class);
    Route::get('digital-services/{serviceId}/delete', [ServiceController::class, 'destroy']);
    Route::resource('tags', TagController::class);
    Route::get('tags/{tagId}/delete', [TagController::class, 'destroy']);    

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('theme-switcher/{activeTheme}', [ThemeController::class, 'switch'])->name('theme-switcher');
    Route::get('layout-switcher/{activeLayout}', [LayoutController::class, 'switch'])->name('layout-switcher');
});