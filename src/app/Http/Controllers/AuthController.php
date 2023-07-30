<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    public function showThanks(){
        return view('thanks');
    }

    public function showLogin(){
        return view('auth.login');
    }
}