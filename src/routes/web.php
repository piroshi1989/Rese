<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThanksController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SearchShopsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopRegisterController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//ログインしなくてもみられるページ
Route::get('/menu', [MenuController::class, 'showMenu']);
Route::get('/', [ShopController::class, 'showShop']);
Route::get('/search', [SearchShopsController::class, 'searchShops']);
Route::get('/detail/{id}', [ShopController::class, 'showShopDetail'])->name('shop_detail');

//ログイン必要
Route::middleware('auth')->group(function () {
  Route::get('/thanks', [ThanksController::class, 'showThanks']);
});

  //認証必要
Route::middleware('verified')->group(function () {
  //一般ユーザのみ
  Route::group(['middleware' => ['can:user']], function () {
    Route::prefix('mypage')->group(function () {
      Route::get('/', [MyPageController::class, 'showMyPage']);
      //予約削除用ルート
      Route::delete('/mypage/delete',[ReservationController::class, 'destroy']);
      //予約更新用ルート
      Route::patch('/mypage/update', [ReservationController::class, 'update']);
      //予約送信用ルート
      });
    Route::post('/detail/{id}', [ReservationController::class,'store']);

    // お気に入りデータ取得用のルート
    Route::get('/getLikedData/{shopId}', [LikeController::class, 'getLikedData']);
    // お気に入りトグル用のルート
    Route::post('/like', [LikeController::class, 'toggleLike']);
    Route::delete('/like/{likeId}', [LikeController::class, 'toggleLike']);
    //レビュー用ルート
    Route::post('/review', [ReviewController::class, 'storeReview']);
    //決済用ルート
    Route::get('/payment', [PaymentController::class, 'create']);
    Route::post('/payment', [PaymentController::class, 'store']);
  });

  // 管理者
  Route::group(['middleware' => ['can:admin']], function () {
    // 店舗情報、予約管理画面
    Route::get('/management',[ShopRegisterController::class,'showShopInfo']);
    //店舗情報作成、追加
    Route::prefix('shop')->group(function () {
      Route::post('/register', [ShopRegisterController::class,'storeShop']);
      Route::patch('/register', [ShopRegisterController::class,'updateShop']);
      Route::get('/registered',[ShopRegisterController::class,'showShopRegistered']);
    });
    //メール送信用
    Route::post('/mail/confirm',[SendMailController::class,'confirmNoticeMail']);
    Route::post('/mail/send',[SendMailController::class,'sendNoticeMail']);
    //本日の予約内容確認
    Route::get('/today_reservation',[ReservationController::class,'showTodayReservation']);
  });

  // システム管理者のみ
  Route::group(['middleware' => ['auth', 'can:superadmin']], function () {
    Route::prefix('admin')->group(function () {
      Route::get('/register', [AdminController::class, 'showAdminRegister']);
      Route::post('/register', [AdminController::class, 'storeAdmin']);
      Route::get('/registered',[AdminController::class,'showAdminRegistered']);
    });
  });
});