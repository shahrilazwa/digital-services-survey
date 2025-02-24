<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.themes.rubick.top-bar.index', function ($view) {
            $activities = ActivityLog::where('user_id', Auth::id())
                ->latest()
                ->limit(5)
                ->get();
            $view->with('activities', $activities);
        });
    }
}
