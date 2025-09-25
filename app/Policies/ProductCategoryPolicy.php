<?php

namespace App\Policies;

use App\Models\ProductCategory;
use App\Models\User;

class ProductCategoryPolicy
{
    public function view(User $user)
    {
        return $user->all_permissions->contains('slug', 'view_product_categories');
    }

    public function create(User $user)
    {
        return $user->all_permissions->contains('slug', 'create_product_categories');
    }

    public function update(User $user)
    {
        return $user->all_permissions->contains('slug', 'edit_product_categories');
    }

    public function delete(User $user)
    {
        return $user->all_permissions->contains('slug', 'delete_product_categories');
    }
}
