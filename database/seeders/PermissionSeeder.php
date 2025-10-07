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
            ['name' => 'View Users', 'slug' => 'view_users', 'group' => 'Users'],
            ['name' => 'Create Users', 'slug' => 'create_users', 'group' => 'Users'],
            ['name' => 'Edit Users', 'slug' => 'edit_users', 'group' => 'Users'],
            ['name' => 'Delete Users', 'slug' => 'delete_users', 'group' => 'Users'],

            // 🔹 Roles
            ['name' => 'View Roles', 'slug' => 'view_roles', 'group' => 'Roles'],
            ['name' => 'Create Roles', 'slug' => 'create_roles', 'group' => 'Roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit_roles', 'group' => 'Roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete_roles', 'group' => 'Roles'],

            // 🔹 Permissions
            ['name' => 'View Permissions', 'slug' => 'view_permissions', 'group' => 'Permissions'],
            ['name' => 'Create Permissions', 'slug' => 'create_permissions', 'group' => 'Permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'edit_permissions', 'group' => 'Permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete_permissions', 'group' => 'Permissions'],

            // 🔹 Product Categories
            ['name' => 'View Product Categories', 'slug' => 'view_product_categories', 'group' => 'Product Categories'],
            ['name' => 'Create Product Categories', 'slug' => 'create_product_categories', 'group' => 'Product Categories'],
            ['name' => 'Edit Product Categories', 'slug' => 'edit_product_categories', 'group' => 'Product Categories'],
            ['name' => 'Delete Product Categories', 'slug' => 'delete_product_categories', 'group' => 'Product Categories'],

            // 🔹 Vendors
            ['name' => 'View Vendors', 'slug' => 'view_vendors', 'group' => 'Vendors'],
            ['name' => 'Create Vendors', 'slug' => 'create_vendors', 'group' => 'Vendors'],
            ['name' => 'Edit Vendors', 'slug' => 'edit_vendors', 'group' => 'Vendors'],
            ['name' => 'Delete Vendors', 'slug' => 'delete_vendors', 'group' => 'Vendors'],

            //Product
            ['name' => 'View Products', 'slug' => 'view_products', 'group' => 'Products'],
            ['name' => 'Create Products', 'slug' => 'create_products', 'group' => 'Products'],
            ['name' => 'Edit Products', 'slug' => 'edit_products', 'group' => 'Products'],
            ['name' => 'Delete Products', 'slug' => 'delete_products', 'group' => 'Products'],

            // Enumeration
            ['name' => 'View Enumerations', 'slug' => 'view_enumerations', 'group' => 'Enumerations'],
            ['name' => 'Create Enumerations', 'slug' => 'create_enumerations', 'grouii p' => 'Enumerations'],
            ['name' => 'Edit Enumerations', 'slug' => 'edit_enumerations', 'group' => 'Enumerations'],
            ['name' => 'Delete Enumerations', 'slug' => 'delete_enumerations', 'group' => 'Enumerations'],

        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['slug' => $perm['slug']], // supaya tidak duplikat
                [
                    'name'  => $perm['name'],
                    'group' => $perm['group'],
                ]
            );
        }
    }
}
