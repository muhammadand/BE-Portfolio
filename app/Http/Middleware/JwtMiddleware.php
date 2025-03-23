<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (TokenExpiredException) {
            return response()->json(['error' => 'Token expired'], Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException) {
            return response()->json(['error' => 'Token invalid'], Response::HTTP_UNAUTHORIZED);
        } catch (Exception) {
            return response()->json(['error' => 'Token not provided'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
