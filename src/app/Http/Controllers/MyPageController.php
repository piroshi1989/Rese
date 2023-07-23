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
    public function myPageView(){
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
    }

    public function reservationDestroy(Request $request){
        Reservation::find($request->id)->delete();
        return redirect('/mypage')->with('message', '予定を削除しました');
    }
}