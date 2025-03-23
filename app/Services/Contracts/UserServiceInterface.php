<?php

namespace App\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface extends BaseServiceInterface
{
    /**
     * Get all users
     */
    public function getAllUsers(): Collection;
    
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
