<?php

namespace Interfaces\Http\Web\Auth\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Infra\Abstracts\Controller;
use Infra\Persistente\Eloquent\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthenticateGoogleController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): Redirector|RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            Auth::login($user);

            return redirect('/dashboard');
        }

        $newUser = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'password' => encrypt(''),
        ]);

        Auth::login($newUser);

        return redirect('/dashboard');
    }
}
