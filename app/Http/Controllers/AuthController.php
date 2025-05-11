<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class AuthController extends BaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private readonly UserService $userService) {}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="User Registration",
     *     description="Allows users to register for the application",
     *     tags={"Authentication"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Allen Gick"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="allen.gick@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="12345678"
     *                 ),
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *     ),
     * )
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
     *
     * @OA\Post(
     *     path="/api/login",
     *     summary="User Login",
     *     description="Allows users to log in to the application",
     *     tags={"Authentication"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *
     *             @OA\Schema(
     *
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="johndoe@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="12345678"
     *                 ),
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User logged in successfully",
     *     ),
     * )
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
