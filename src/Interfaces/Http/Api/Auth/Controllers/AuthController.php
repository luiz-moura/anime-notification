<?php

namespace Interfaces\Http\Api\Auth\Controllers;

use Illuminate\Support\Facades\Auth;
use Infra\Abstracts\Controller;
use Infra\Abstracts\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = request(['email','password']);

        if(!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'accessToken' =>$token,
            'token_type' => 'Bearer',
        ]);
    }
}
