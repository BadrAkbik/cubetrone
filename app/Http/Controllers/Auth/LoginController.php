<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = User::where('email', $request->email)->first();

        return $user->createToken($user->email)->plainTextToken;

    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
    }
}
