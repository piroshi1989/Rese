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


        
$shops = Shop::with('area', 'genre')->get()->sortBy('id');
$user_id = Auth::id();

//$shops = $shops->filter(function ($shop) use ($user_id) {
 //   $genreName = $shop->genre->name;
   // $romanizedGenreName = str_replace(['焼肉', '寿司', 'ラーメン', 'イタリアン', '居酒屋'], ['yakiniku', 'sushi', 'ramen', 'italian', 'izakaya'], $genreName);
//    $imageName = $romanizedGenreName . '.jpg';
  //  $imagePath = 'storage/' . $imageName;
  //  $shop->imagePath = $imagePath;

    // お気に入りされているかを判定し、その情報を追加
    //$shop->is_liked = $shop->isLikedBy($user_id);

    // お気に入りされている店舗のみをフィルタリング
    //return $shop->is_liked;
//});

$likedShopIds = Like::where('user_id', $user_id)->pluck('shop_id')->toArray();

// Shop モデルから $likedShopIds に含まれる shop_id に対応する店舗を取得
$likedShops = Shop::whereIn('id', $likedShopIds)->get();

$areas = Area::all();
$genres = Genre::all();


        return view('mypage', compact('reservations', 'user_name', 'today', 'now', 'shops'));
    }

    public function reservationDestroy(Request $request){
        Reservation::find($request->id)->delete();
        return redirect('/mypage')->with('message', '予定を削除しました');
    }
}