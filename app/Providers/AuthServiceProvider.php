<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin';
        });

        // Gate untuk 'support' role
        Gate::define('is-support', function ($user) {
            return $user->role === 'support';
        });

        // Gate untuk 'finance' role
        Gate::define('is-finance', function ($user) {
            return $user->role === 'finance';
        });
    }
}
