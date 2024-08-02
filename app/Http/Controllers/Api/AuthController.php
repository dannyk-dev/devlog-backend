<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated_user = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $user = User::create($validated_user);
        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'Created succesfully'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user)
        {
            throw ValidationException::withMessages([
                'message' => ['Invalid credentials']
            ]);
        }

        if (!Hash::check($request->password, $user->password))
        {
            throw ValidationException::withMessages([
                'message' => ['Invalid Credentials']
            ]);
        }

        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
