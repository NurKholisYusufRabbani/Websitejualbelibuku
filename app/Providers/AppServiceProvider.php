<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Default redirect setelah login.
     */
    public static string $HOME = '/books'; // Ubah dari const ke static property

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        // Redirect berdasarkan peran (role)
        $this->app->booted(function () {
            self::$HOME = Auth::check() && Auth::user()->role === 'admin' 
                ? '/admin/dashboard' 
                : '/books';
        });
    }
}
