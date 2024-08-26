<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;

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
        Route::middleware('guest')->group(function () {
            Route::get('/login', function () {
                if (Auth::check()) {
                    $user = Auth::user();
                    // Redirect berdasarkan role
                    if ($user->role === 'admin') {
                        return Redirect::route('admin.dashboard');
                    } else {
                        return Redirect::route('dashboard');
                    }
                }
                return view('auth.login'); // Tampilkan halaman login jika belum login
            });
        });
    }
}
