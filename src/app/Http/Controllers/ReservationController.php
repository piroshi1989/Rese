<?php

namespace App\Http\Controllers;
use App\Models\Reservation;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    public function reservationStore(ReservationRequest $request){
        $formType = $request->input('form_type');
        if ($formType === 'reservation_form') {
        // 予約フォームからの送信の場合の処理
        $reservation = $request->all();
        Reservation::create($reservation);

        return view('done');
        }
    }

    public function reservationDestroy(Request $request){
        Reservation::find($request->id)->delete();
        return redirect('/mypage')->with('message', '予約を削除しました');
    }

    public function reservationUpdate(ReservationRequest $request){
        if(!empty($request)){
        $reservation = $request->all();
        Reservation::find($request->id)->update($reservation);
        return redirect('/mypage')->with('message', '予約を更新しました');}
        else{
            return redirect('/mypage');
        }
    }
}