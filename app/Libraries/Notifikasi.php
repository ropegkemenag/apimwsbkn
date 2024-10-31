<?php

namespace App\Libraries;

class Notifikasi
{

  public function sendWhatsapp($phone,$text)
  {
    $client = \Config\Services::curlrequest();

    $response = $client->post('https://kudus.wablas.com/api/send-message', [
        'form_params' => ['phone' => $phone,'message' => $text],
        'headers' => [
            'Authorization' => 'S5NIVfnMzYPi90mUwjcmdVvtyw2sMnp8lHmejgf0KCUOR3QOw6k1E0tmpVTkPfXq'
        ],
        'verify' => false
    ]);

    $body = json_decode($response->getBody());

    if($body->status){
      // return $body->data->messages[0]->id;
      return TRUE;
      // print_r($body->status);
    }else{
      // print_r($body->status);
      return FALSE;
    }

  }

  public function sendWhatsappTemplate($phone,$text)
  {
    $client = \Config\Services::curlrequest();

    $response = $client->post('https://kudus.wablas.com/api/send-message', [
        'form_params' => ['phone' => $phone,'message' => $text],
        'headers' => [
            'Authorization' => 'S5NIVfnMzYPi90mUwjcmdVvtyw2sMnp8lHmejgf0KCUOR3QOw6k1E0tmpVTkPfXq'
        ],
        'verify' => false
    ]);

    $body = json_decode($response->getBody());

    if($body->status){
      return TRUE;
      // print_r($body->status);
    }else{
      // print_r($body->status);
      return FALSE;
    }

  }

}
