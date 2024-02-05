<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Donation;

class SendSms implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $donation_id;
    protected $phone_number;
    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($donation_id, $phone_number, $message)
    {
        $this->donation_id = $donation_id;
        $this->phone_number = $phone_number;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $donation = Donation::find($this->donation_id);

        $userkey=env('ZENZIVA_USERKEY'); // userkey lihat di zenziva

        $passkey=env('ZENZIVA_PASSKEY'); // set passkey di zenziva

        $url = "https://alpha.zenziva.net/apps/smsapi.php";

        $curlHandle = curl_init();

        curl_setopt($curlHandle, CURLOPT_URL, $url);

        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$this->phone_number.'&pesan='.urlencode($this->message));

        curl_setopt($curlHandle, CURLOPT_HEADER, 0);

        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);

        curl_setopt($curlHandle, CURLOPT_POST, 1);

        $results = curl_exec($curlHandle);
        $xml=simplexml_load_string($results);
        if ($xml->message->text == 'Success') {
            $donation->sms_status = 'Sent';
        } else {
            $donation->sms_status = $xml->message->text;
        }
        $donation->save();

        curl_close($curlHandle);
    }
}
