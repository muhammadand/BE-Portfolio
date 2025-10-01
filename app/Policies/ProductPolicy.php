<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Menentukan apakah user boleh melihat semua produk.
     */
    public function viewAny(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'view_products');
    }

    /**
     * Menentukan apakah user boleh melihat produk tertentu.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->all_permissions->contains('slug', 'view_products');
    }

    /**
     * Menentukan apakah user boleh membuat produk.
     */
    public function create(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'create_products');
    }

    /**
     * Menentukan apakah user boleh update produk.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->all_permissions->contains('slug', 'edit_products');
    }

    /**
     * Menentukan apakah user boleh delete produk.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->all_permissions->contains('slug', 'delete_products');
    }
}
