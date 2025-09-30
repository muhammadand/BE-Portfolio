<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'view_permissions');
    }

    public function view(User $user, Permission $permission): bool
    {
        return $user->all_permissions->contains('slug', 'view_permissions');
    }

    public function create(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'create_permissions');
    }

    public function update(User $user, Permission $permission): bool
    {
        return $user->all_permissions->contains('slug', 'edit_permissions');
    }

    public function delete(User $user, Permission $permission): bool
    {
        return $user->all_permissions->contains('slug', 'delete_permissions');
    }
}
