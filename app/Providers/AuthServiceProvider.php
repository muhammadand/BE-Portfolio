<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ProductCategory;
use App\Policies\ProductCategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Map model ke policy-nya.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ProductCategory::class => ProductCategoryPolicy::class,
        // Tambahkan model lain & policy di sini jika perlu
    ];

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
        // Daftarkan semua policy
        $this->registerPolicies();

        // Jika ingin, bisa tetap definisikan Gates khusus role
      
    }
}
