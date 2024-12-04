<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Create a new user",
     *     description="Creates a new user and returns it",
     *     operationId="createUser",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object that needs to be created",
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="joao"),
     *             @OA\Property(property="email", type="string", example="joao@starsoft.com"),
     *             @OA\Property(property="password", type="string", example="123456"),
     *             @OA\Property(property="password_confirmation", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        return response()->json([
            'data' => $this->userRepository->register($request->validated())
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate a user",
     *     description="Authenticates a user and returns token",
     *     operationId="authUser",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User object that needs to be authenticated",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="email", example="joao@starsoft.com"),
     *             @OA\Property(property="password", type="string", example="your password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User authenticated successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function login(LoginUserRequest $request)
    {
        return response()->json([
            'data' => $this->userRepository->login($request->validated())
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout a user",
     *     description="Remover a user token",
     *     operationId="logoutUser",
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=201,
     *         description="User logout successfully",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function logout()
    {
        return response()->json([
            'data' => $this->userRepository->logout()
        ]);
    }
}
