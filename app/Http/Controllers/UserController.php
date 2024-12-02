<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();

        $user = $this->model->where('email', '=', $data['email'])->firstOrFail();
        
        if(!Hash::check($data['password'], $user->password)){
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }
        
        return response()->json([
            'access_token' => $user->createToken($user->name.'-AuthToken')->plainTextToken
        ]);
    }
}
