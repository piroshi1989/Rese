<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;

class AuthController extends Controller
{
    public function showThanks(){
        return view('thanks');
    }

    public function showLogin(){
        return view('auth.login');
    }
}