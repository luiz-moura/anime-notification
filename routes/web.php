<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Interfaces\Http\Web\Member\Controller\SubscriptionController;
use Interfaces\Http\Web\Member\Controller\MemberController;
use Interfaces\Http\Web\Users\ProfileController;

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::post('setToken', function (Request $request) {
    $token = $request->input('fcm_token');
    $request->user()->update(['fcm_token' => $token]);

    return response()->noContent();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/schedule', [MemberController::class, 'schedule'])->name('schedule');

    Route::prefix('anime')->controller(SubscriptionController::class)->group(function () {
        Route::get('{id}/subscribe', 'subscribeMember')->name('anime.subscribe');
        Route::get('{id}/unsubscribe', 'unsubscribeMember')->name('anime.unsubscribe');
    });

    Route::get('settings', function () {
        return Inertia::render('Settings');
    })->name('profile.settings');
});

Route::get('/', function () {
    dd(now()->format('Y-m-d H:i:s'));
});

require __DIR__ . '/auth.php';
