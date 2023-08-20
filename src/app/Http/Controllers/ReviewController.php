<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function storeReview(ReviewRequest $request)
    {
        $formType = $request->form_type;
        if ($formType === 'review_form') {
            $user_id = Auth::id();
            $reviewed_shop = Review::where('user_id', $user_id)->where('shop_id', $request->shop_id)->first();

            if ($reviewed_shop) {
                $reviewed_shop->rating = $request->input('rating');
                $reviewed_shop->comment = $request->input('comment');
                $reviewed_shop->save();
                $message = 'レビューを更新しました';
            } else {
                $new_review = new Review([
                    'user_id' => $user_id,
                    'shop_id' => $request->shop_id,
                    'rating' => $request->input('rating'),
                    'comment' => $request->input('comment'),
                ]);
                $new_review->save();
                $message = 'レビューを登録しました';
        }

        return redirect(route('shop_detail', ['id' => $request->shop_id]))->with('message', $message);
        }
    }
}