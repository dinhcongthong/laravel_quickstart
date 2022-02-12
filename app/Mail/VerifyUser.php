<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verify_code)
    {
        $this->code = $verify_code;
        $this->mail = env('MAIL_USERNAME');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Verify your email address';
        $verify_code = $this->code;
        return $this->view('emails.verify_user', compact('verify_code'))
                ->from($this->mail,'ThomasDC')
                ->subject($title);
    }
}
