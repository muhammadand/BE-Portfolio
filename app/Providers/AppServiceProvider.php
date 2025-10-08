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
use App\Services\Contracts\VendorServiceInterface;
use App\Services\Concretes\VendorService;
use App\Repositories\Vendor\Contracts\VendorRepositoryInterface;
use App\Repositories\Vendor\Concretes\VendorRepository;
use App\Services\Contracts\ProductServiceInterface;
use App\Services\Concretes\ProductService;
use App\Repositories\Product\Contracts\ProductRepositoryInterface;
use App\Repositories\Product\Concretes\ProductRepository;
use App\Repositories\Enumeration\Contracts\EnumerationRepositoryInterface;
use App\Repositories\Enumeration\Concretes\EnumerationRepository;
use App\Services\Contracts\EnumerationServiceInterface;
use App\Services\Concretes\EnumerationService;
use App\Repositories\Customer\Contracts\CustomerRepositoryInterface;
use App\Repositories\Customer\Concretes\CustomerRepository;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Concretes\CustomerService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Customer
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(CustomerServiceInterface::class, CustomerService::class);
        // Enumeration
        $this->app->bind(EnumerationRepositoryInterface::class, EnumerationRepository::class);
        $this->app->bind(EnumerationServiceInterface::class, EnumerationService::class);
        //Product
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        //Vendor
        $this->app->bind(VendorServiceInterface::class, VendorService::class);
        $this->app->bind(VendorRepositoryInterface::class, VendorRepository::class);
        //Activity Logs
        $this->app->bind(
            ActivityRepositoryInterface::class,
            ActivityRepository::class
        );
        //Product Category
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
