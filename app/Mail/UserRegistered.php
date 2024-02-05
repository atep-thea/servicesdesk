<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Campaign;
use App\User;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $campaigns = Campaign::where('status', 'Published')->where('featured', true)->orderBy('created_at', 'desc')->take(3)->get();

        return $this->subject('Selamat Datang di Peduli Negeri')
                    ->view('email.congrate')
                    ->with([
                        'user_name' => $this->user->name,
                        'campaigns' => $campaigns
                    ]);
    }
}
