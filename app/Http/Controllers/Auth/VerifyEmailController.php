<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Cache;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request)
    {

        $resetCode = Cache::get($request->user()->email);

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        $resetCode->delete();

        return response()->json([
            'message' => 'Email successfuly Verified'
        ]);

    }
}
