<?php

namespace App\Services\Contracts;

use App\Services\Base\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface extends BaseServiceInterface
{
    /**
     * Get all users
     */
    public function getAllUsers(): Collection;

    /**
     * Get filtered users with pagination
     *
     * @param Request|null $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFilteredUsers(?Request $request = null, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get user by ID
     */
    public function getUserById(int $id): ?Model;

    /**
     * Create user
     */
    public function createUser(array $data): Model;

    /**
     * Update user
     */
    public function updateUser(int $id, array $data): Model;

    /**
     * Delete user
     */
    public function deleteUser(int $id): bool;

    /**
     * Get active users
     */
    public function getActiveUsers(): Collection;
}
