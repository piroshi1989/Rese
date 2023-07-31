<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SearchShopsController;
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
Route::get('/detail/{id}', [ShopController::class, 'showShopDetail']);

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MyPageController::class, 'showMyPage']);
    Route::post('/detail/{id}', [ShopController::class, 'ReservationStore']);
    Route::delete('/mypage/delete', [MyPageController::class, 'reservationDestroy']);
    Route::post('/like',[LikeController::class,'toggleLike']);
    Route::delete('/like/{likeId}', [LikeController::class, 'toggleLike']);
    });