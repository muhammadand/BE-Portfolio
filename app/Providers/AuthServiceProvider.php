<?php

namespace App\Providers;

use App\Services\Concretes\AuthService;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register the service bindings
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }
}
