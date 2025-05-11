<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends BaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly UserService $userService) {}

    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->userService->registerUser($request->validated());

            return $this->successResponse(
                result: $data,
                message: 'User registered successfully.'
            );

        } catch (\Exception $e) {
            return $this->errorResponse(
                error: 'Registration failed. Please try again.',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->userService->loginUser($request->validated());

            return $this->successResponse($data, 'Login Successfully.');

        } catch (\Exception $e) {
            return $this->errorResponse(
                error: $e->getMessage(),
                code: Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
