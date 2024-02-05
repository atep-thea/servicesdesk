<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WA extends Model
{
    public static function send($donation_id, $phone, $message, $account_number_view) {
        $donation = Donation::find($donation_id);


        $token="e81c398e346299b6d893d7d46b4ae6585ae9136801a01"; // userkey lihat di zenziva

        $uid="62895341005759"; // set passkey di zenziva

        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',

            );
        $data = array(
                "token" => $token,
                "uid" => $uid,
                "to" => $phone,
                "custom_id" => $account_number_view,
                "text" =>$message);

        $data_string = json_encode($data);

        $url = 'https://www.waboxapp.com/api/send/chat';
        //dd($userkey);
        //$url2 = 'http://103.16.199.187/masking/send.php?username=dpu_dt&password=p4ssw0rd&hp=085720300917&message=test+sms';

        // $curlHandle = curl_init();

        // curl_setopt($curlHandle, CURLOPT_URL, $url);

        // curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data_string);

        // curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        // curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);

        // $results = curl_exec($curlHandle);
        // dd($results);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.waboxapp.com/api/send/chat",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 600,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $data_string,
          CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Content-Type: application/x-www-form-urlencoded",
            "Postman-Token: 4f11a6e9-a424-4ffb-ab00-fa9650d7039a",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
          ),
        ));

        $response = curl_exec($curl);
        //dd($response);



        // $xml=simplexml_load_string($results);
        // if ($xml->message->text == 'Success') {
        //     $donation->sms_status = 'Sent';
        // } else {
        //     $donation->sms_status = $xml->message->text;
        // }
        //if ($results > 1) {
        $donation->wa_status = 'Sent';
        //} else {
        //    $donation->wa_status = 'Failed';
        //}
        $donation->save();

        curl_close($curl);
    }
}
