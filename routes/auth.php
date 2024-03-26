<?php

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['throttle:6,1'])
                ->name('verification.send');

    Route::post('/verify-email', VerifyEmailController::class)
                ->middleware(['throttle:6,1'])
                ->name('verification.verify');

    Route::delete('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::post('login', [LoginController::class, 'store'])->name('login');

Route::post('/register', [UserController::class, 'store'])->name('user.register');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');