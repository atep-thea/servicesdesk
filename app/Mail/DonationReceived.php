<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Donation;

class DonationReceived extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $donation;
    protected $account;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   public function __construct($user, $donation, $account)
    {
        $this->user = $user;
        $this->donation = $donation;
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Donation::where('id', $this->donation->id)->update([
            'mail_status' => 'Sent'
        ]);
        return $this->subject('Terima Kasih. Donasi Telah Diterima')
                    ->view('email.terimadonasi')
                    ->with([
                        'title' => $this->user->title,
                        'name' => $this->user->name,
                        'email' => $this->user->email,
                        'phone' => $this->user->phone,
                        'amount' => $this->donation->amount,
                        'account' => $this->account,
                        'campaign_name' => $this->donation->campaign->title,
                        'bank' => $this->donation->bank,
                        'channel' => $this->donation->payment_channel
                    ]);
    }
}
