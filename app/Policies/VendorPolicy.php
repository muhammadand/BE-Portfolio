<?php 

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;

class VendorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'view_vendors');
    }

    public function view(User $user, Vendor $vendor): bool
    {
        return $user->all_permissions->contains('slug', 'view_vendors');
    }

    public function create(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'create_vendors');
    }

    public function update(User $user, Vendor $vendor): bool
    {
        return $user->all_permissions->contains('slug', 'edit_vendors');
    }

    public function delete(User $user, Vendor $vendor): bool
    {
        return $user->all_permissions->contains('slug', 'delete_vendors');
    }

//     public function restore(User $user, Vendor $vendor): bool
// {
//     return $user->all_permissions->contains('slug', 'restore_vendors');
// }

// public function forceDelete(User $user, Vendor $vendor): bool
// {
//     return $user->all_permissions->contains('slug', 'force_delete_vendors');
// }

}
