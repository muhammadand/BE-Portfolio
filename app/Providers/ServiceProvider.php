<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Services\Contracts\BaseServiceInterface;
use App\Services\Concretes\BaseService;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseServiceInterface::class, BaseService::class);
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
