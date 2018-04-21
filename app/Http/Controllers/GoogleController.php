<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Login using Google
     *
     * @param Request $request
     * @return
     */
    public function login(Request $request) {
        return Socialite::driver('google')
            ->stateless()
            ->scopes([
                'profile',
                'email',
                'https://www.googleapis.com/auth/gmail.readonly'
            ])
            ->redirect();
    }

    /**
     * @param Request $request
     * @return
     */
    public function callback(Request $request) {
        return Socialite::driver('google')->stateless()->user;
    }
}