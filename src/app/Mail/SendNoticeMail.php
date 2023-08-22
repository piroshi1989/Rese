<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SendNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $body;
    protected $shopName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->subject = $email['subject'];
        $this->body  = $email['body'];

        $this->senderShop = Auth::user()->shop->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notice', [
            'body'  => $this->body,
            'shopName' => $this->senderShop,
            ])->subject($this->subject);
    }
}