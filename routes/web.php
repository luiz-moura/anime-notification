<?php

use Domain\Animes\Actions\NotifyMembersThatAnimeWillBeBroadcastAction;
use Domain\Animes\Contracts\AnimeRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Interfaces\Http\Web\Member\Controller\SubscriptionController;
use Interfaces\Http\Web\Member\Controller\MemberController;
use Interfaces\Http\Web\Member\Controller\NotificationController;
use Interfaces\Http\Web\Users\ProfileController;

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::patch('/', 'update')->name('profile.update');
        Route::delete('/', 'destroy')->name('profile.destroy');
    });

    Route::prefix('anime')->controller(SubscriptionController::class)->group(function () {
        Route::get('{id}/subscribe', 'subscribeMember')->name('anime.subscribe');
        Route::get('{id}/unsubscribe', 'unsubscribeMember')->name('anime.unsubscribe');
    });

    Route::get('schedule', [MemberController::class, 'schedule'])->name('member.schedule');
    Route::post('notification/set-token', [NotificationController::class, 'setToken']);

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('settings', function () {
        return Inertia::render('Settings');
    })->name('profile.settings');
});

Route::get('/', function () {
    dd(now()->format('Y-m-d H:i:s'));
});

require __DIR__ . '/auth.php';
