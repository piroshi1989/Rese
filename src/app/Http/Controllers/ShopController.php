<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Http\Requests\ReservationRequest;

class ShopController extends Controller
{
    public function shopView(){
        $shops = Shop::with('area', 'genre')->get()->sortBy('id');
        
        $shops = $shops->map(function ($shop) {
        $genreName = $shop->genre->name; // ジャンル名を取得
        $romanizedGenreName = str_replace(['焼肉', '寿司', 'ラーメン', 'イタリアン', '居酒屋'], ['yakiniku', 'sushi', 'ramen', 'italian', 'izakaya'], $genreName);        $imageName = $romanizedGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
        $imagePath = 'storage/' . $imageName; // 画像パス
        $shop->imagePath = $imagePath; // 画像パスを追加
        return $shop;
        });

        $areas = Area::all();
        $genres = Genre::all();

        return view('shop_all', compact('shops', 'areas', 'genres'));
    }

    public function favorite(Request $request)
{
    $user_id = Auth::user()->id; //1.ログインユーザーのid取得
    $shop_id = $request->shop_id; //2.投稿idの取得
    $already_liked = Favorite::where('user_id', $user_id)->where('shop_id', $shop_id)->first(); //3.

    if (!$already_liked) { //もしこのユーザーがこの投稿にまだいいねしてなかったら
        $favorite = new Favorite; //4.Likeクラスのインスタンスを作成
        $favorite->shop_id = $shop_id; //Likeインスタンスにreviews_id,user_idをセット
        $favorite->user_id = $user_id;
        $favorite->save();
    } else { //もしこのユーザーがこの投稿に既にいいねしてたらdelete
        Favorite::where('shop_id', $shop_id)->where('user_id', $user_id)->delete();
    }
    //5.この投稿の最新の総いいね数を取得
    $shops_likes_count = Shops::withCount('favorites')->findOrFail($shop_id)->likes_count;
    $param = [
        'shops_likes_count' => $shops_likes_count,
    ];
    return response()->json($param); //6.JSONデータをjQueryに返す
}

public function index(Request $request)
{
    $shops = Review::withCount('favorites')->orderBy('id', 'desc')->paginate(10);
    $param = [
        'shops' => $shops,
    ];
    return view('shops.index', $param);
}

    public function shopDetailView($id){
        $shop = Shop::findOrFail($id);
        $genreName = $shop->genre->name; // ジャンル名を取得
        $romanizedGenreName = str_replace(['焼肉', '寿司', 'ラーメン', 'イタリアン', '居酒屋'], ['yakiniku', 'sushi', 'ramen', 'italian', 'izakaya'], $genreName);
        $imageName = $romanizedGenreName . '.jpg'; // ジャンル名を画像ファイル名として使用
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

    public function reservationStore(ReservationRequest $request){
        $form = $request->all();
        Reservation::save($form);
        return view('thanks');
    }
}