<?php

namespace App\Providers;
use App\Services\Contracts\ProductCategoryServiceInterface;
use App\Services\Concretes\ProductCategoryService;
use App\Services\Contracts\RoleServiceInterface;
use App\Services\Concretes\RoleService;
use App\Services\Contracts\PermissionServiceInterface;
use App\Services\Concretes\PermissionService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Role\Contracts\RoleRepositoryInterface;
use App\Repositories\Role\Concretes\RoleRepository;
use App\Repositories\Permission\Contracts\PermissionRepositoryInterface;
use App\Repositories\Permission\Concretes\PermissionRepository;
use App\Repositories\ActivityLog\Contracts\ActivityRepositoryInterface;
use App\Repositories\ActivityLog\Concretes\ActivityRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ActivityRepositoryInterface::class,
            ActivityRepository::class
        );

       
        $this->app->bind(
            \App\Repositories\ProductCategory\Contracts\ProductCategoryRepositoryInterface::class,
            \App\Repositories\ProductCategory\Concretes\ProductCategoryRepository::class
        );
        $this->app->bind(
            \App\Services\Contracts\ProductCategoryServiceInterface::class,
            \App\Services\Concretes\ProductCategoryService::class
        );
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
        
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);
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
