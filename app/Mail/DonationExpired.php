<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Donation;

class DonationExpired extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $donation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $donation)
    {
        $this->user = $user;
        $this->donation = $donation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     Donation::where('id', $this->donation->id)->update([
    //         'mail_status' => 'Sent'
    //     ]);

    //     return $this->subject('Donasi Dibatalkan')
    //                 ->view('email.notifExpired')
    //                 ->with([
    //                     'title' => $this->user->title,
    //                     'name' => $this->user->name,
    //                     'amount' => $this->donation->amount,
    //                     'campaign_name' => $this->donation->campaign->title,
    //                 ]);
    // }
}
