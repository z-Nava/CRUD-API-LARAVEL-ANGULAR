<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'rol_id' => 'required|integer|min:1|max:3'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'rol_id' => $request->get('rol_id')
        ]);

        $user->save();

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout(Request $request)
    {
         //$request->user->token()->revoke();
            return response()->json([
                'message' => 'Cierra sesión exitoso'
            ],200);
    }

    public function respondWithToken($token)
    {
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        //'expires_in' => auth()->factory()->getTTL() * 60
    ]);
    }
}
