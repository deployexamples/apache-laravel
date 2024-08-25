<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // try {
        //     $credentials = $request->only('email', 'password');

        //     if ($token = $this->guard()->attempt($credentials)) {
        //         $this->infoLog($request, false, 'login',
        //             [
        //                 'message' => 'user logged in',
        //                 'description' => [
        //                     'user_name' => $request->user()->name
        //                 ]
        //             ]);
        //         return response()->json(['status' => 1, 'token' => $token, 'id' => Auth::id()])->header('Authorization', $token);
        //     }
        //     return response()->json(['error' => 'login_error'], 401);
        // }
        try {
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status' => 0
                ]);
            }
            $user = $request->user();

            $tokenResult = $user->createToken($user->id);
            $token = $tokenResult->token;
            return response()->json(['status' => 1, 'token' => $tokenResult->accessToken]);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
    public function getLoggedUser(Request $request)
    {
        try {
            if (Auth::check()) {
                $user = User::findOrFail(Auth::id())->only(['id', 'name', 'email']);
                return response()->json([
                    'getLoggedUserInfo' => $user
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
