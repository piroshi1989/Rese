<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class SearchShopsController extends Controller
{
    public function searchShops(Request $request){
        $area_id = $request->input('area');
        $genre_id = $request->input('genre');
        $keyword = $request->input('keyword');

        $searchedShops= Shop::with('genre', 'area')->ShopsSearch($area_id, $genre_id, $keyword)->get();

        $searchedShops = $searchedShops->map(function ($shop) {
        $user_id = Auth::id();
        $romanizedGenreName = $shop->genre->romaji_name; // ジャンル名を取得
        $imageName = $romanizedGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
        $imagePath = 'storage/' . $imageName; // 画像パス
        $shop->imagePath = $imagePath; // 画像パスを追加

        $isLiked = $shop->isLikedBy($user_id);
        $like_id = $isLiked ? $shop->likes->where('user_id', $user_id)->first()->id : null;
        $shop->is_liked = $shop->isLikedBy($user_id); // お気に入り情報を追加
        $shop->is_liked = $isLiked;
        $shop->like_id = $like_id;
        return $shop;
        });
        $areas = Area::all();
        $genres = Genre::all();

        return view('shop_all', compact('searchedShops','areas', 'genres',));
    }
}