<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(UserRequest $request){
        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());
        return $this->response_success($user, 'Registro exitoso');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email o contraseña incorrecta'],
            ]);
        }
        return $this->response_success($user->createToken('AuthToken')->plainTextToken);
        
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->response_success([]);
    }
}
