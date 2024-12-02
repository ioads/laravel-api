<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function register(Request $request)
    {
        $data = $request->all();

        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->all();

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
