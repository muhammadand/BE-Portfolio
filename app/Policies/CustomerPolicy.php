<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy
{
    public function view(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'view_customers');
    }

    public function create(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'create_customers');
    }

    public function update(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'edit_customers');
    }

    public function delete(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'delete_customers');
    }
}
