<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LikeController extends Controller
{
public function toggleLike(Request $request)
{
    $user_id = Auth::id();
    $shop_id = $request->shop_id;

    // 既にお気に入りに登録されているかチェック
    $already_liked = Like::where('user_id', $user_id)->where('shop_id', $shop_id)->exists();

    if (!$already_liked) {
        // お気に入り登録がされていない場合は新しくレコードを作成
        $like = new Like;
        $like->user_id = $user_id;
        $like->shop_id = $shop_id;
        $like->save();

        $isLiked = true; // お気に入り登録がされた場合はtrueを返す
    } else {
        // お気に入り登録がされている場合はレコードを削除
        Like::where('user_id', $user_id)->where('shop_id', $shop_id)->delete();

        $isLiked = false; // お気に入り登録が解除された場合はfalseを返す
    }

    // お気に入り登録の状態を返す
    return response()->json(['liked' => $isLiked]);
}
}