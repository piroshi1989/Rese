<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Like;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function showShop(){
        $shops = Shop::with('area', 'genre')->get()->sortBy('id');
        
        $shops = $shops->map(function ($shop) {
        $user_id = Auth::id();
        $alphabetGenreName = $shop->genre->alphabet_name; // ジャンル名を取得
        $imageName = $alphabetGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
        $imagePath = 'storage/' . $imageName; // 画像パス
        $shop->imagePath = $imagePath; // 画像パスを追加
        return $shop;
        });

        $areas = Area::all();
        $genres = Genre::all();

        return view('shop_all', compact('shops', 'areas', 'genres'));
    }

    public function showShopDetail($id){
        $shop = Shop::findOrFail($id);
        $alphabetGenreName = $shop->genre->alphabet_name; // ジャンル名を取得
        $imageName = $alphabetGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
        $imagePath = 'storage/' . $imageName; // 画像のパスを構築\

        $today = Carbon::now()->format('Y-m-d');

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

        return view('shop_detail', compact('shop', 'imagePath','options', 'today', 'numbers'));
    }

    public function showDone(){
        return view('done');
    }
}