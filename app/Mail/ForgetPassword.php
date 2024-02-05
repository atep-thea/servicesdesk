<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->user = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = $this->token;
        $name = $this->user->name;
        User::where('email',$this->user->email)->update([
            'forget_token' => $token
        ]);
        return $this->subject('Verifikasi Lupa Password')
                    ->view('email.forgetPassword')
                    ->with([
                        'name' => $name,
                        'token' => $token
                    ]);
    }
}
