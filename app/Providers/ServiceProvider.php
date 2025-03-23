<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Concretes\UserService;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // We don't bind BaseServiceInterface to BaseService anymore since BaseService is now abstract
        
        // Bind UserServiceInterface to UserService
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
