<?php

namespace App\Services\Concretes;

use App\Http\Resources\Api\User\UserResource;
use App\Models\User;
use App\Repositories\User\Contracts\UserRepositoryInterface;
use App\Services\Base\Concretes\BaseService;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthService extends BaseService implements AuthServiceInterface
{
    /**
     * UserService constructor.
     *
     * @param  UserRepositoryInterface  $userRepository
     */
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
        $this->setRepository($userRepository);
    }

    /**
     * Register a new user.
     *
     * @param  array<string, mixed>  $data
     * @return array
     */
    public function register(array $data): array
    {
        /** @var User $user */
        $user = $this->repository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $this->prepareUserWithToken($user);
    }

    /**
     * Authenticate a user.
     *
     * @param  array<string, mixed>  $credentials
     * @return array
     * @throws AuthenticationException If authentication fails
     */
    public function login(array $credentials): array
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new AuthenticationException('Invalid credentials');
        }

        /** @var User $user */
        $user = Auth::user();

        return $this->prepareUserWithToken($user, $token);
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

    /**
     * @param  User  $user
     * @param  string|null  $token
     * @return array
     */
    private function prepareUserWithToken(User $user, string $token = null): array
    {
        return [
            'user' => new UserResource($user),
            'token' => $token ?? JWTAuth::fromUser($user),
            'token_type' => 'bearer',
        ];
    }
}
