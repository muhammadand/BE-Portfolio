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
        // Ambil role
        $adminRole   = Role::where('slug', 'admin')->first();
        $supportRole = Role::where('slug', 'support')->first();
        $financeRole = Role::where('slug', 'finance')->first();

        // Ambil user
        $superAdmin   = User::where('email', 'admin@gmail.com')->first();
        $muhammadAndi = User::where('email', 'muhammad.andi@gmail.com')->first();
        $rachmat      = User::where('email', 'rachmat@gmail.com')->first();
        $belva        = User::where('email', 'belva@gmail.com')->first();

        // Assign roles
        if ($superAdmin && $adminRole) {
            $superAdmin->roles()->sync([$adminRole->id]);

            // Ambil permission untuk Users + Product Categories saja
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

        if ($muhammadAndi && $adminRole) {
            $muhammadAndi->roles()->sync([$adminRole->id]);
        }

        if ($rachmat && $supportRole) {
            $rachmat->roles()->sync([$supportRole->id]);

            // Support hanya bisa View Users
            $viewUsers = Permission::firstOrCreate(
                ['slug' => 'view_users'],
                ['name' => 'View Users']
            );

            $supportRole->permissions()->syncWithoutDetaching([$viewUsers->id]);
        }

        if ($belva && $financeRole) {
            $belva->roles()->sync([$financeRole->id]);
        }
    }
}
