<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MyPageController extends Controller
{
    public function showMyPage()
    {
        $user_id = Auth::id();
        $user_name = Auth::user()->name;

        $today = Carbon::now()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');

        $reservations = Reservation::where('user_id', $user_id)
        ->where(function ($query) use ($today, $now) {
            $query->where('date', '>', $today)
        ->orWhere(function ($query) use ($today, $now) {
            $query->where('date', '=', $today)->where('time', '>=', $now);
        });
        })
        ->orderBy('date', 'asc')
        ->simplePaginate(1);

        $likedShopIds = Like::where('user_id', $user_id)->pluck('shop_id')->toArray();

        $likedShops = Shop::whereIn('id', $likedShopIds)->get();
        // Shop モデルから $likedShopIds に含まれる shop_id に対応する店舗を取得
        $likedShops = $likedShops->map(function ($likedShop) {
            $romanizedGenreName = $likedShop->genre->alphabet_name; // ローマ字のジャンル名を取得
            $imageName = $romanizedGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
            $imagePath = 'https://rese-s3.s3.ap-northeast-1.amazonaws.com/' . $imageName; // 画像パス
            $likedShop->imagePath = $imagePath; // 画像パスを追加

            return $likedShop;
        });

        $startTime = Carbon::parse('11:30');

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