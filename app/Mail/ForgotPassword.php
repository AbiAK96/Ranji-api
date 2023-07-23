<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;
    public $first_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email, $first_name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->first_name = $first_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.user.password-reset')->subject('Password Reset')->with([
            'token' => $this->token,
            'email' => $this->email,
            'first_name' => $this->first_name
        ]);
    }
}
