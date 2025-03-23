<?php

namespace App\Services\Concretes;

use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService implements AuthServiceInterface
{
    /**
     * Register a new user.
     *
     * @param array<string, mixed> $data
     * @return string JWT token
     */
    public function register(array $data): string
    {
        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Generate token
        return JWTAuth::fromUser($user);
    }

    /**
     * Authenticate a user.
     *
     * @param array<string, mixed> $credentials
     * @return string JWT token
     * @throws AuthenticationException If authentication fails
     */
    public function login(array $credentials): string
    {
        try {
            if (!$token = Auth::attempt($credentials)) {
                throw new AuthenticationException('Invalid credentials');
            }
            
            return $token;
        } catch (JWTException $e) {
            throw new AuthenticationException('Failed to generate token: ' . $e->getMessage());
        }
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable The authenticated user
     * @throws AuthenticationException If user is not authenticated
     */
    public function me(): \Illuminate\Contracts\Auth\Authenticatable
    {
        $user = Auth::user();
        
        if (!$user) {
            throw new AuthenticationException('User not authenticated');
        }
        
        return $user;
    }

    /**
     * Refresh the token.
     *
     * @return string New JWT token
     * @throws AuthenticationException If token refresh fails
     */
    public function refresh(): string
    {
        try {
            $token = Auth::refresh();
            
            if (!$token) {
                throw new AuthenticationException('Failed to refresh token');
            }
            
            return $token;
        } catch (JWTException $e) {
            throw new AuthenticationException('Failed to refresh token: ' . $e->getMessage());
        }
    }

    /**
     * Invalidate the token.
     *
     * @return bool
     * @throws AuthenticationException If logout fails
     */
    public function logout(): bool
    {
        try {
            Auth::logout();
            return true;
        } catch (JWTException $e) {
            throw new AuthenticationException('Failed to logout: ' . $e->getMessage());
        }
    }
}
