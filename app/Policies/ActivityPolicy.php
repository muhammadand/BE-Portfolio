<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityPolicy
{
    /**
     * Cek apakah user bisa melihat semua activity logs
     */
    public function viewAny(User $user): bool
    {
        return $user->all_permissions->contains('slug', 'view_activity_logs');
    }

    /**
     * Cek apakah user bisa melihat activity log tertentu
     */
    public function view(User $user, Activity $activity): bool
    {
        return $user->all_permissions->contains('slug', 'view_activity_logs');
    }

    /**
     * Disable create/update/delete untuk activity logs via policy
     */
    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Activity $activity): bool
    {
        return false;
    }

    public function delete(User $user, Activity $activity): bool
    {
        return false;
    }
}
