<?php

use Illuminate\Support\Facades\Route;
use Interfaces\Http\Web\Auth\Controllers\AuthenticatedSessionController;
use Interfaces\Http\Web\Auth\Controllers\AuthenticateGoogleController;
use Interfaces\Http\Web\Auth\Controllers\ConfirmablePasswordController;
use Interfaces\Http\Web\Auth\Controllers\EmailVerificationNotificationController;
use Interfaces\Http\Web\Auth\Controllers\EmailVerificationPromptController;
use Interfaces\Http\Web\Auth\Controllers\NewPasswordController;
use Interfaces\Http\Web\Auth\Controllers\PasswordController;
use Interfaces\Http\Web\Auth\Controllers\PasswordResetLinkController;
use Interfaces\Http\Web\Auth\Controllers\RegisteredUserController;
use Interfaces\Http\Web\Auth\Controllers\VerifyEmailController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('auth/google', [AuthenticateGoogleController::class, 'redirectToGoogle'])
        ->name('auth.google');

    Route::get('auth/google/callback', [AuthenticateGoogleController::class, 'handleGoogleCallback'])
        ->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
