<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $reservationShop;
    protected $reservationTime;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $reservationShop, $reservationTime)
    {
    $this->user = $user;
    $this->reservationShop = $reservationShop;
    $this->reservationTime = $reservationTime;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reminder', [
            'user' => $this->user,
            'reservationShop' => $this->reservationShop,
            'reservationTime' => $this->reservationTime,
        ])->subject('予約確認メール');
    }
}