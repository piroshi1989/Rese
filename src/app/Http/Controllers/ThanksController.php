<?php

namespace App\Http\Controllers;

class ThanksController extends Controller
{
    public function showThanks(){
        return view('thanks');
    }
}