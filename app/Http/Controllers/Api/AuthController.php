<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Генерируем access_token
        $token = JWTAuth::fromUser($user);
        // Генерируем refresh_token
        $refreshToken = JWTAuth::fromUser($user, ['exp' => now()->addMinutes(config('jwt.refresh_ttl'))->timestamp]);

        $user->update(['refresh_token' => $refreshToken]);

        $payload = JWTAuth::setToken($token)->getPayload();
        $expiresIn = $payload['exp'] - time();

        \Log::info('User registered successfully', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => $expiresIn,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Проверяем учетные данные и получаем токен
        if (! $token = JWTAuth::attempt($credentials)) {
            \Log::warning('Login failed', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Получаем пользователя после успешной аутентификации
        $user = JWTAuth::setToken($token)->user();
        if (! $user) {
            \Log::error('Failed to retrieve user after successful authentication', ['email' => $request->email]);
            throw new \Exception('User not found after authentication');
        }

        // Генерируем refresh_token
        $refreshToken = JWTAuth::fromUser($user, ['exp' => now()->addMinutes(config('jwt.refresh_ttl'))->timestamp]);
        $user->update(['refresh_token' => $refreshToken]);

        $payload = JWTAuth::setToken($token)->getPayload();
        $expiresIn = $payload['exp'] - time();

        \Log::info('User logged in', ['user_id' => $user->id]);

        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => $expiresIn,
        ], 200);
    }

    public function refresh(Request $request)
    {
        try {
            // Проверяем текущий токен (refresh_token)
            $newToken = JWTAuth::refresh();
            $user = JWTAuth::setToken($newToken)->user();

            if (! $user) {
                \Log::error('Failed to retrieve user during token refresh');
                throw new \Exception('User not found during token refresh');
            }

            $newRefreshToken = JWTAuth::fromUser($user, ['exp' => now()->addMinutes(config('jwt.refresh_ttl'))->timestamp]);
            $user->update(['refresh_token' => $newRefreshToken]);

            $payload = JWTAuth::setToken($newToken)->getPayload();
            $expiresIn = $payload['exp'] - time();

            \Log::info('Token refreshed', [
                'user_id' => $user->id,
                'expires_in' => $expiresIn,
            ]);

            return response()->json([
                'access_token' => $newToken,
                'refresh_token' => $newRefreshToken,
                'token_type' => 'bearer',
                'expires_in' => $expiresIn,
            ], 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            \Log::warning('Refresh token expired');
            throw ValidationException::withMessages([
                'token' => 'The refresh token has expired.',
            ]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            \Log::warning('Invalid refresh token');
            throw ValidationException::withMessages([
                'token' => 'The refresh token is invalid.',
            ]);
        }
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            if (!$token) {
                \Log::warning('No token provided for logout');
                return response()->json(['message' => 'No token provided'], 401);
            }

            $user = auth('api')->user();
            if (!$user) {
                \Log::warning('No authenticated user found for logout', ['token' => $token]);
                return response()->json(['message' => 'No authenticated user'], 401);
            }

            JWTAuth::invalidate($token);
            $user->update(['refresh_token' => null]);
            \Log::info('User logged out', ['user_id' => $user->id, 'token' => $token]);

            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            \Log::warning('Invalid token during logout', ['error' => $e->getMessage(), 'token' => $token ?? 'none']);
            return response()->json(['message' => 'Invalid token'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            \Log::warning('Expired token during logout', ['error' => $e->getMessage(), 'token' => $token ?? 'none']);
            return response()->json(['message' => 'Token has expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
            \Log::warning('Blacklisted token during logout', ['error' => $e->getMessage(), 'token' => $token ?? 'none']);
            return response()->json(['message' => 'Token is blacklisted'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            \Log::error('JWT error during logout', ['error' => $e->getMessage(), 'token' => $token ?? 'none']);
            return response()->json(['message' => 'Token error'], 401);
        }
    }
}
