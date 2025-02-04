<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\UpdateUserProfileInformation;


class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('public.login');
        });
        
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            
            if ($user && Hash::check($request->password, $user->password)) {
                // Force authentication to ensure Auth::id() is available
                Auth::login($user);

                // Capture IP address using request helper
                $ipAddress = $request->ip(); 

                // Log successful login with IP address
                ActivityLogger::log('Login', 'User', Auth::id(), [
                    'email' => $user->email,
                    'ip_address' => $ipAddress
                ]);

                return $user;
            }

            // Log failed login attempt with IP address
            ActivityLogger::log('Login Failed', 'User', null, [
                'email' => $request->email,
                'ip_address' => $request->ip()
            ]);           

            // If authentication fails, throw a validation exception
            throw ValidationException::withMessages([
                Fortify::username() => [trans('auth.failed')],
            ]);            
        });        
    }
}
