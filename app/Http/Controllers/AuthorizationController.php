<?php

namespace App\Http\Controllers;

class AuthorizationController extends Controller
{
    public function verify()
    {
        $botman = app('botman');
        $botman->verifyServices(env('TOKEN_VERIFY'));
    }
}
