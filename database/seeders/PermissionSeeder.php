<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // 🔹 Users
            ['name' => 'View Users', 'slug' => 'view_users'],
            ['name' => 'Create Users', 'slug' => 'create_users'],
            ['name' => 'Edit Users', 'slug' => 'edit_users'],
            ['name' => 'Delete Users', 'slug' => 'delete_users'],

            // 🔹 Roles
            ['name' => 'View Roles', 'slug' => 'view_roles'],
            ['name' => 'Create Roles', 'slug' => 'create_roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit_roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete_roles'],

            // 🔹 Permissions
            ['name' => 'View Permissions', 'slug' => 'view_permissions'],
            ['name' => 'Create Permissions', 'slug' => 'create_permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'edit_permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete_permissions'],

            // 🔹 Product Categories
            ['name' => 'View Product Categories', 'slug' => 'view_product_categories'],
            ['name' => 'Create Product Categories', 'slug' => 'create_product_categories'],
            ['name' => 'Edit Product Categories', 'slug' => 'edit_product_categories'],
            ['name' => 'Delete Product Categories', 'slug' => 'delete_product_categories'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['slug' => $perm['slug']], // biar tidak duplikat
                ['name' => $perm['name']]
            );
        }
    }
}
