<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function showReview($id)
    {
        $shop = Shop::findOrFail($id);
        $alphabetGenreName = $shop->genre->alphabet_name; // ジャンル名を取得
        $imageName = $alphabetGenreName . '.jpg';// ジャンル名を画像ファイル名として使用
        $imagePath = 'https://rese-s3.s3.ap-northeast-1.amazonaws.com/' . $imageName; // 画像のパスを構築\

        $user_id = Auth::id();
        $likeData = Like::where('user_id', $user_id)->where('shop_id', $shop->id)->exists();
        $shop->likeData = $likeData;

        $today = Carbon::now()->format('Y-m-d');
        $now = Carbon::now()->format('H:i');
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

        return view('review', compact('shop','user_id', 'imagePath', 'userReview', 'reservations'));
    }


    public function storeReview(ReviewRequest $request)
    {
        $formType = $request->form_type;
        if ($formType !== 'review_form') {
            return;
        }

        $user_id = Auth::id();
        $review = Review::where('user_id', $user_id)->where('shop_id', $request->shop_id)->first();

        $dir = 'images';
        $uploadedFile = $request->file('image');


        if ($review) {
            $review->rating = $request->input('rating');
            $review->comment = $request->input('comment');

            if ($uploadedFile) {
                $file_name = $uploadedFile->getClientOriginalName();
    
                $uploadedFile->storeAs('public/' . $dir, $file_name);
    
                $review->image_url = 'storage/' . $dir . '/' . $file_name;
            }
            $review->save();

            $message = 'レビューを更新しました';
            } else {
                $review = new Review;
                $review->user_id = $user_id;
                $review->shop_id = $request->shop_id;
                $review->rating = $request->input('rating');
                $review->comment = $request->input('comment');

                if ($uploadedFile) {
                    $file_name = $uploadedFile->getClientOriginalName();
        
                    $uploadedFile->storeAs('public/' . $dir, $file_name);
        
                    $review->image_url = 'storage/' . $dir . '/' . $file_name;
                }

                $review->save();

                $message = 'レビューを登録しました';
        }

        return redirect(route('shop_detail', ['id' => $request->shop_id]))->with('message', $message);
        }
    
        public function destroyReview(Request $request)
    {
        Review::findOrFail($request->id)->delete();
        $message = 'レビューを削除しました';
        
        return redirect(route('shop_detail', ['id' => $request->shop_id]))->with('message', $message);
    }
}