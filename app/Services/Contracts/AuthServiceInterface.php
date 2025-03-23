<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceInterface
{
    /**
     * Register a new user.
     *
     * @param array<string, mixed> $data
     * @return string JWT token
     */
    public function register(array $data): string;

    /**
     * Authenticate a user.
     *
     * @param array<string, mixed> $credentials
     * @return string JWT token
     * @throws AuthenticationException If authentication fails
     */
    public function login(array $credentials): string;

    /**
     * Get the authenticated user.
     *
     * @return Authenticatable The authenticated user
     * @throws AuthenticationException If user is not authenticated
     */
    public function me(): Authenticatable;

    /**
     * Refresh the token.
     *
     * @return string New JWT token
     * @throws AuthenticationException If token refresh fails
     */
    public function refresh(): string;

    /**
     * Invalidate the token.
     *
     * @return bool
     * @throws AuthenticationException If logout fails
     */
    public function logout(): bool;
}
