<?php

namespace App\Policies;

use App\Models\User;

class EnumerationPolicy
{
    public function view(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'view_enumerations');
    }

    public function create(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'create_enumerations');
    }

    public function update(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'edit_enumerations');
    }

    public function delete(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'delete_enumerations');
    }
}
