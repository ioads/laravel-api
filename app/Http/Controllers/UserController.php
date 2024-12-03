<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterUserRequest $request)
    {
        return response()->json([
            'data' => $this->userRepository->register($request->validated())
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        return response()->json([
            'data' => $this->userRepository->login($request->validated())
        ]);
    }

    public function logout()
    {
        return response()->json([
            'data' => $this->userRepository->logout()
        ]);
    }
}
