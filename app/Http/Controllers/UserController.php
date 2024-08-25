<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        try {
            $users = User::get(['id','name','email']);
            return response()->json(
                [
                    'status' => 'success',
                    'users' => $users
                ], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function store(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->save();
            return response()->json([
                'status' => 1,
                'message' => "user created successfully."
            ]);
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}
