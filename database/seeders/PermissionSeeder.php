<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Users
            ['name' => 'View Users', 'slug' => 'view_users'],
            ['name' => 'Create Users', 'slug' => 'create_users'],
            ['name' => 'Edit Users', 'slug' => 'edit_users'],
            ['name' => 'Delete Users', 'slug' => 'delete_users'],

            // Product Categories
            ['name' => 'View Product Categories', 'slug' => 'view_product_categories'],
            ['name' => 'Create Product Categories', 'slug' => 'create_product_categories'],
            ['name' => 'Edit Product Categories', 'slug' => 'edit_product_categories'],
            ['name' => 'Delete Product Categories', 'slug' => 'delete_product_categories'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['slug' => $perm['slug']], // cek slug biar tidak duplicate
                ['name' => $perm['name']]
            );
        }
    }
}
