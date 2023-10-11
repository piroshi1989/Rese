<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Mail\SendNoticeMail;

use App\Models\User;
class SendMailController extends Controller
{
    public function confirmNoticeMail(SendMailRequest $request)
    {
        $email = $request->all();
        return view('mail_confirm', compact('email'));
    }

    public function sendNoticeMail(SendMailRequest $request)
    {
        //フォームから受け取ったactionの値を取得
        $action = $request->input('action');

        //フォームから受け取ったactionを除いたinputの値を取得
        $email = $request->except('action');

        //一般ユーザ
        $users = User::where('role', 0)->get();

        //actionの値で分岐
        if($action !== 'submit'){
            return redirect('/management')
            ->withInput($email);
        } else {
            foreach($users as $user){
            //一般ユーザーすべてにメールを送信
            \Mail::to($user['email'])->send(new SendNoticeMail($email));
            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();
            }
            //送信完了ページのviewを表示
            return view('mail_complete');
        }
    }
}