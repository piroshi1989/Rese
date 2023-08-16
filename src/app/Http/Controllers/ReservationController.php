<?php

namespace App\Http\Controllers;
use App\Models\Reservation;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        $formType = $request->input('form_type');
        if ($formType === 'reservation_form') {
            // 予約フォームからの送信の場合の処理
            $reservation = $request->all();
            Reservation::create($reservation);

            return view('done');
        }
    }

    public function destroy(Request $request)
    {
        Reservation::find($request->id)->delete();
        return redirect('/mypage')->with('message', '予約を削除しました');
    }

    public function update(ReservationRequest $request)
    {
        if(!empty($request)){
            $reservation = $request->all();
            Reservation::find($request->id)->update($reservation);

            return redirect('/mypage')->with('message', '予約を更新しました');}
        else{
            return redirect('/mypage');
        }
    }

    public function showTodayReservation()
    {
        $shopId = Auth::user()->shop_id;
        $today = Carbon::now()->format('Y-m-d');

        $todayReservations = Reservation::where('shop_id', $shopId)->where('date', $today)->simplePaginate(10);

        return view('today_reservation',compact('todayReservations', 'today', ));
    }
}