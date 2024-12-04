<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function register(array $data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $data)
    {
        $user = $this->model->where('email', '=', $data['email'])->firstOrFail();
        
        if(!Hash::check($data['password'], $user->password)){
            Log::info('User {id} failed to login.', ['id' => $user->id]);
            
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }
        
        return response()->json([
            'access_token' => $user->createToken($user->name.'-AuthToken')->plainTextToken
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
    
        return response()->json([
            'message' => 'Usuário desconectado.'
        ]);
    }
}