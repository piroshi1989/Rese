<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\Like;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function showShop(Request $request){

        $shops = Shop::all();

        $shops = $shops->map(function ($shop) {
            $user_id = Auth::id();
            $alphabetGenreName = $shop->genre->alphabet_name; // ジャンル名を取得
            $imageName = $alphabetGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
            $imagePath = 'https://rese-s3.s3.ap-northeast-1.amazonaws.com/' . $imageName; // 画像パス
            $shop->imagePath = $imagePath; // 画像パスを追加
            $likeData = Like::where('user_id', $user_id)->where('shop_id', $shop->id)->exists();
            $shop->likeData = $likeData;
            $ratings = Review::where('shop_id', $shop->id)->pluck('rating')->toArray();

            // 評価が存在する場合、平均値を計算
            if (!empty($ratings)) {
                $averageRating = array_sum($ratings) / count($ratings);
            } else {
                $averageRating = 0; // 評価がない場合は0として扱う（または適切なデフォルト値）
            }

            // 各店舗に平均評価を追加
            $shop->average_rating = $averageRating;

            return $shop;
        });

        // ソートのパラメータを取得
        $sort = $request->input('sort', 'default');

        switch ($sort) {
            case 'random':
                $shops = $shops->shuffle();
                    break;
            case 'rating_desc':
                // 平均評価が高い順に並び替え
                $shops = $shops->sortByDesc('average_rating')->values();
                    break;
            case 'rating_asc':
                $shops = $shops->sortBy(function ($shop) {
                    // 平均評価が0の場合、無限大(INF)を返す
                    return $shop->average_rating === 0 ? INF : $shop->average_rating;
                })->values();
                    break;
            default:
                // デフォルトの並び替え方法を指定（最新順）
                $shops = $shops->sortBy('created_at')->values();
                break;
        }

        $areas = Area::all();
        $genres = Genre::all();

        return view('shop_all', compact('shops', 'areas', 'genres',));
    }

    public function showShopDetail($id){
        $shop = Shop::findOrFail($id);
        $alphabetGenreName = $shop->genre->alphabet_name; // ジャンル名を取得
        $imageName = $alphabetGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
        $imagePath = 'https://rese-s3.s3.ap-northeast-1.amazonaws.com/' . $imageName; // 画像のパスを構築\

        $today = Carbon::now()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');

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

        $user_id = Auth::id();
        $reservations = Reservation::where('user_id', $user_id)->where('shop_id', $shop->id)
        ->where(function ($query) use ($today, $now) {
            $query->where('date', '<', $today)
        ->orWhere(function ($query) use ($today, $now) {
            $query->where('date', '=', $today)->where('time', '<=', $now);
        });
        })->get();
        
        $adminShopId = Auth::check() ? Auth::user()->shop_id : null;

        // ユーザーがその店舗に対してレビューをしているかを判定
        $userReview = Review::where('user_id', $user_id)
        ->where('shop_id', $shop->id)
        ->first();

        $reviews = Review::all();

        $ratings = [
            1 => 'とても不満足でした',
            2 => '不満足でした',
            3 => '満足でした',
            4 => '大変満足でした',
            5 => '最高でした',
        ];


        $reviews = Review::all()->map(function ($review) use ($ratings) {
            $review->reviewText = $ratings[$review->rating] ?? '評価なし'; // 評価が存在しない場合のデフォルト値を設定
            return $review;
        });

        return view('shop_detail', compact('shop','user_id', 'imagePath','options', 'today', 'numbers','reservations', 'adminShopId','userReview', 'reviews' ));
    }
}