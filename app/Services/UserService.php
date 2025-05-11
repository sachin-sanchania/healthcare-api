<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService extends BaseService
{
    /**
     * Get the base model class for healthcare professional related operations.
     */
    public function baseModel(): string
    {
        return User::class;
    }

    /**
     * @throws \Exception
     */
    public function registerUser(array $data): array
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'name' => $user->name,
                'email' => $user->email,
            ];

        } catch (\Exception $e) {
            Log::critical('User registration failed: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * @throws \Exception
     */
    public function loginUser(array $credentials): array
    {
        try {
            $user = User::where('email', $credentials['email'])->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password)) {
                throw new \RuntimeException('Invalid credentials. Please enter correct data.', Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

            return [
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email,
            ];
        } catch (\Exception $e) {
            Log::error('Login failed: '.$e->getMessage());
            throw $e;
        }
    }
}
