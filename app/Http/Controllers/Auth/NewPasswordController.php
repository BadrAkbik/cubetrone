<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $request)
    {

        $user = User::firstWhere('email', $request->email);

        $user->update($request->safe()->only('password'));

        event(new PasswordReset($user));

        return response()->json(['message' =>'password has been successfully reseted'], 200);
    }
}
