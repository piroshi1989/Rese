<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopReviewRequest;

use App\Models\ShopReview;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function reviewStore(ShopReviewRequest $request){
        $formType = $request->input('form_type');
        if ($formType === 'review_form') {
        // レビューフォームからの送信の場合の処理

        $user_id = Auth::id();
        $reviewed_shop = ShopReview::where('user_id', $user_id)->where('shop_id', $request->shop_id)->first();
        //もしすでにreviewされていたらreviewを更新する
        if($reviewed_shop){
            $reviewed_shop->rating = $request->input('rating');
            $reviewed_shop->comment = $request->input('comment');
            $reviewed_shop->save();

            return  redirect(route('shop_detail', ['id' => $request->shop_id]))->with('message', 'レビューを更新しました');
        }else{
            $new_review = new ShopReview([
                'user_id' => $user_id,
                'shop_id' => $request->shop_id,
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]);
            $new_review->save();
            //新規なら登録

            return  redirect(route('shop_detail', ['id' => $request->shop_id]))->with('message', 'レビューを登録しました');
        }
        
        }
    }
}