<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Auth\Events\Registered;
use App\Notifications\EmailVerificationNotification;


use Illuminate\Auth\Events\Verified;


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

       // $this->authorize('create-delete-users');
        $user->save();

        //event(new Registered($user));
        //$user->notify(new EmailVerificationNotification);

       // $verificationUrl = URL::temporarySignedRoute(
            //'verification.verify', now()->addMinutes(30), ['id' => $user->id]
       //);
       //Mail::to($user->email)->send(new EmailVerificationNotification($verificationUrl));
        $url = URL::temporarySignedRoute(
            'verification.verify', now()->addMinutes(30), ['id' => $user->id, 'hash' => sha1($user->email)]
        );
        $user->notify(new EmailVerificationNotification($url));

        return response()->json([
            'message' => 'Usuario registrado exitosamente, se ha enviado un correo de verificación',
            'user' => $user
        ], 201);
    }
    

    public function login(LoginRequest $request)
    {
    
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $request->user();

            if (!$user->hasVerifiedEmail()) {
                return response(['error' => 'Email not verified'], 403);
            }

            return response(['user' => $user, 'token' => $user->createToken('token')->plainTextToken]);
        }

        return response(['error' => 'Unauthorized'], 401);
    
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }

    public function respondWithToken($token)
    {
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        //'expires_in' => auth()->factory()->getTTL() * 60
    ]);
    }

    public function verify(Request $request)
    {
     $user = User::findOrFail($request->id);

     if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
         return response(['message' => 'Invalid verification link']);
     }

     if ($user->hasVerifiedEmail()) {
         return response(['message' => 'Email already verified']);
     }

     $user->markEmailAsVerified();
     $user->status = 'verified';
        $user->save();
     event(new Verified($user));
     return response(['message' => 'Email verified']);
    }

    public function test(Request $request)
    {
        return response()->json([
            "status"=>200,
            "msg"=>"Test exitoso"]);
    }
}
