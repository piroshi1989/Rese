<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyPageController extends Controller
{
    public function showMyPage(){
        $user_id = Auth::id();
        $user_name = Auth::user()->name;

        $today = Carbon::now()->format('Y-m-d');

        $now = Carbon::now()->format('H:i');

        $reservations = Reservation::where('user_id', $user_id)
        ->where('date', '>=', $today)
        ->where('time', '>=', $now)
        ->orderBy('date', 'desc')->simplePaginate(1);
        //予約は


        return view('mypage', compact('reservations', 'user_name', 'today', 'now'));

        while ($startTime <= Carbon::parse('22:00')) {
            $options[$startTime->format('H:i')]= $startTime->format('H:i');
            $startTime->addMinutes(30);
        }
        //予約可能時間を11:30から22:00として、30分毎に時間を生成。$optionsに格納

        for($number=1;$number<=10;$number++){
            $numbers[] = $number;
        }
        //予約人数を1～10人までとして$numbersに格納

        return view('mypage', compact('reservations', 'user_name', 'today', 'now', 'likedShops', 'options', 'numbers'));
    }
}