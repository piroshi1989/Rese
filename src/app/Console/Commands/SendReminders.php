<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;

class SendReminders extends Command
{
    // ここの'reminder:send'がコマンドで使われる
    protected $signature = 'reminder:send';

    protected $description = 'Send reminder emails to todays reserved users';

    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');

        // 今日の日付で予約情報を取得
        $reservations = Reservation::whereDate('date', $today)->get();

        foreach ($reservations as $reservation) {
            $user = $reservation->user;
            $reservationShop = $reservation->shop->name;
            $reservationTime = $reservation->time;

            // ReminderEmail クラスのインスタンスを作成し、ユーザー情報を渡す
            $reminderEmail = new ReminderEmail($user, $reservationShop, $reservationTime);

            // メールを送信する
            Mail::to($user->email)->send($reminderEmail);
        }

        $this->info('Reminder emails have been dispatched!');
    }
}