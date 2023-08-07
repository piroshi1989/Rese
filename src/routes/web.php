<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SearchShopsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopRegisterController;
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

Route::get('/menu', [MenuController::class, 'showMenu']);
Route::get('/', [ShopController::class, 'showShop']);
Route::get('/search', [SearchShopsController::class, 'searchShops']);
Route::get('/detail/{id}', [ShopController::class, 'showShopDetail'])->name('shop_detail');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MyPageController::class, 'showMyPage']);
    Route::get('/thanks', [AuthController::class, 'showThanks']);
    Route::post('/detail/{id}', [ReservationController::class, 'storeReservation']);
    Route::delete('/mypage/delete',
    [ReservationController::class, 'destroyReservation']);
    Route::patch('/mypage/update', [ReservationController::class, 'updateReservation']);
    Route::post('/like',[LikeController::class,'toggleLike']);
    Route::delete('/like/{likeId}', [LikeController::class, 'toggleLike']);
    Route::post('/review', [ReviewController::class, 'reviewStore']);
    });
    
    // 管理者以上
Route::group(['middleware' => ['auth', 'can:admin']], function () {
  // 店舗登録
  Route::get('/shop/register',[ShopRegisterController::class,'showShopRegister']);
  Route::post('/shop/register', [ShopRegisterController::class,'storeShopRegister']);
  Route::patch('/shop/register', [ShopRegisterController::class,'updateShopRegister']);
  Route::get('/shop/registered',[ShopRegisterController::class,'showShopRegistered']);
  

  Route::get('/management',[MenuController::class,'showManagementMenu']);
  Route::get('/shop/reservation',[ReservationController::class,'showReservation']);
  });

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:superadmin']], function () {
    Route::get('/admin/register', [AdminController::class, 'showAdminRegister']);
    Route::post('/admin/register', [AdminController::class, 'storeAdminRegister']);
    Route::get('/admin/registered',[AdminController::class,'showAdminRegistered']);
});