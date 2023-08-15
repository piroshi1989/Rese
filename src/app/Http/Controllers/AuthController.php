<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showThanks(){
        return view('thanks');
    }
}