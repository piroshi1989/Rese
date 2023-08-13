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

    protected $title;
    protected $body;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emails)
    {
        $this->title = $emails['title'];
        $this->body  = $emails['body'];

        $this->senderShop = auth::user()->shop->name;
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
            ])->subject("{$this->title}");
    }
}