<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            // 'id' => $githubUser->getId(),
            // 'nickname' => $githubUser->getNickname(),
            'name' => $githubUser->getName(),
            'avatar' => $githubUser->getAvatar(),
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);

        Auth::login($user);
 
        return redirect('/');
    }

    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return to_route('login');
    }
}
