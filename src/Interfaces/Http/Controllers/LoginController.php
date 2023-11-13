<?php

namespace Interfaces\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Infra\Abstracts\Controller;
use Infra\Persistente\Eloquent\Models\User;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            Auth::login($user);

            return redirect('/dashboard');
        } else {
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id'=> $googleUser->id,
                'password' => encrypt('')
            ]);

            Auth::login($newUser);

            return redirect('/dashboard');
        }
    }
}
