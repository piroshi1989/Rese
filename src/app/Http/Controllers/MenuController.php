<?php

namespace App\Http\Controllers;

class MenuController extends Controller
{
    public function showMenu()
    {
        return view('menu');
    }
}