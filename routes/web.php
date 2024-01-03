<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Interfaces\Http\Controllers\AnimeController;
use Interfaces\Http\Controllers\LoginController;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Process\InputStream;
use Illuminate\Http\UploadedFile;
use Infra\Persistente\Eloquent\Models\Anime;
use Symfony\Component\HttpFoundation\File\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/schedule', function () {
        $animes = Anime::with(['images', 'broadcast', 'genres'])->get();

        return Inertia::render('Schedule', compact('animes'));
    })->name('schedule');

    Route::get('settings', function () {
        return Inertia::render('Settings');
    })->name('profile.settings');
});

Route::get('/', function() {
    dd(now()->timezone('Asia/Tokyo')->format('Y-m-d H:i:s'));
});

require __DIR__ . '/auth.php';
