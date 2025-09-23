<?php

namespace App\Providers;
use App\Services\Contracts\ProductCategoryServiceInterface;
use App\Services\Concretes\ProductCategoryService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
        // Bind interface ke implementasinya
          $this->app->bind(ProductCategoryServiceInterface::class, ProductCategoryService::class);
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(false);
        Model::unguard();

        DB::prohibitDestructiveCommands(app()->isProduction());

        Http::preventStrayRequests();

        Date::use(CarbonImmutable::class);

        URL::forceHttps(app()->isProduction());
    }
}
