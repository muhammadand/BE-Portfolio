<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class UserRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Pastikan role superadmin ada
        $superAdminRole = Role::firstOrCreate(
            ['slug' => 'superadmin'],
            ['name' => 'Super Admin']
        );

        $adminRole   = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        $supportRole = Role::firstOrCreate(['slug' => 'support'], ['name' => 'Support']);
        $financeRole = Role::firstOrCreate(['slug' => 'finance'], ['name' => 'Finance']);

        // 🔹 Ambil user
        $superAdmin   = User::where('email', 'admin@gmail.com')->first();
        $muhammadAndi = User::where('email', 'muhammad.andi@gmail.com')->first();
        $rachmat      = User::where('email', 'rachmat@gmail.com')->first();
        $belva        = User::where('email', 'belva@gmail.com')->first();

        // 🔹 Superadmin -> dapat semua permissions
        if ($superAdmin) {
            $superAdmin->roles()->sync([$superAdminRole->id]);

            $allPermissions = Permission::pluck('id')->toArray();
            $superAdminRole->permissions()->sync($allPermissions);
        }

        // 🔹 Admin -> hanya Users & Categories
        if ($muhammadAndi) {
            $muhammadAndi->roles()->sync([$adminRole->id]);

            $permissions = Permission::whereIn('slug', [
                'view_users',
                'create_users',
                'edit_users',
                'delete_users',

                'view_product_categories',
                'create_product_categories',
                'edit_product_categories',
                'delete_product_categories',
            ])->pluck('id')->toArray();

            $adminRole->permissions()->sync($permissions);
        }

        // 🔹 Support -> hanya View Users
        if ($rachmat) {
            $rachmat->roles()->sync([$supportRole->id]);

            $viewUsers = Permission::firstOrCreate(
                ['slug' => 'view_users'],
                ['name' => 'View Users']
            );

            $supportRole->permissions()->syncWithoutDetaching([$viewUsers->id]);
        }

        // 🔹 Finance -> belum ada permissions khusus
        if ($belva) {
            $belva->roles()->sync([$financeRole->id]);
        }
    }
}
