<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    public function view(User $user)
    {
       

        return $user->all_permissions->contains('slug', 'view_roles');
    }

    public function create(User $user)
    {
        

        return $user->all_permissions->contains('slug', 'create_roles');
    }

    public function update(User $user)
    {
       

        return $user->all_permissions->contains('slug', 'edit_roles');
    }

    public function delete(User $user)
    {
    

        return $user->all_permissions->contains('slug', 'delete_roles');
    }
}
