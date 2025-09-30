<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function view(User $user)
    {
        return $user->all_permissions->contains('slug', 'view_users');
    }

    public function create(User $user)
    {
        return $user->all_permissions->contains('slug', 'create_users');
    }

    public function update(User $user)
    {
        return $user->all_permissions->contains('slug', 'edit_users');
    }

    public function delete(User $user)
    {
        return $user->all_permissions->contains('slug', 'delete_users');
    }
}
