<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShopRequest;

use Illuminate\Support\Facades\Auth;

use App\Models\Shop;
use App\Models\Genre;
use App\Models\Area;
use App\Models\Reservation;

class ShopRegisterController extends Controller
{
    public function showShopInfo(){
        $shop_id = Auth::user()->shop_id;
        $genres = Genre::all();
        $areas = Area::all();
        $shop = Shop::find($shop_id);

        $reservations = Reservation::where('shop_id', $shop_id)->orderBy('date', 'asc')->orderBy('time', 'asc')->simplePaginate(10);
        
        return view('shop_management',compact('genres', 'areas', 'shop', 'reservations'));
    }

    public function storeShopRegister(ShopRequest $request){
        $user = Auth::user();

        if(empty($user->shop_id)){
        $store = new Shop;
        $store->name = $request->name;
        $store->genre_id = $request->genre_id;
        $store->area_id = $request->area_id;
        $store->detail = $request->detail;
        $store->save();
        //新しい店舗を登録

        $shopId = $store->id;

        $user->shop_id = $shopId;
        $user->save();
        //登録した店舗と管理者を紐づけ


        return redirect('/shop/registered')->with('message', '店舗情報を登録しました');
        }
    }

    public function updateShopRegister(ShopRequest $request){
            $user = Auth::user();

            if(!empty($user->shop_id)){
            $shop = $request->all();
            Shop::find($user->shop_id)->update($shop);
            
            return redirect('/shop/registered')->with('message', '店舗情報が更新されました');
            //もしshop_idが登録されていたら更新する
            }
    }
    
    public function showShopRegistered(){
        return view('shop_registered');
    }
}