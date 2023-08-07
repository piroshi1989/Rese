<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function showAdminRegister(){
        $shops = Shop::all();
        return view('admin_register',compact('shops'));
    }

    public function storeAdminRegister(UserRequest $request){
        $store = new User;
        $store->role = $request->role;
        $store->name = $request->name;
        $store->email = $request->email;
        $store->shop_id = $request->shop_id;
        $store->password = Hash::make($request->password);
        $store->save();

        return redirect('/admin/registered');
    }

    public function showAdminRegistered(){
        return view('admin_registered');
    }
}