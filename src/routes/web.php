<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\LikeController;
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

Route::get('/menu', [MenuController::class, 'menuView']);
Route::get('/shop_all', [ShopController::class, 'shopView']);
Route::get('/shop_all/{id}', [ShopController::class, 'shopDetailView']);

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MyPageController::class, 'myPageView']);
    Route::post('/shop_all/{id}', [ShopController::class, 'ReservationStore']);
    Route::post('/like',[LikeController::class,'toggleLike']);
    Route::delete('/like/{likeId}', [LikeController::class, 'toggleLike']);
    Route::delete('/mypage/delete', [MyPageController::class, 'reservationDestroy']);
});