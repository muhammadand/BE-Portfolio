<?php

namespace App\Repositories\Concretes;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    protected function model(): string
    {
        return User::class;
    }

    /**
     * Find users by role
     *
     * @param string $role
     * @return Collection
     */
    public function findByRole(string $role): Collection
    {
        // This is a placeholder implementation
        // In a real application with role management, you would implement the actual logic
        return $this->model->where('role', $role)->get();
    }
}
