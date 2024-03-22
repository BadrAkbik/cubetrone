<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $user = User::where('email', $request->email)->first();

        return $user->createToken($request->device_name)->plainTextToken;

    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();
    }
}
