<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pns extends BaseController
{
    public function index()
    {
        //
    }

    public function datautama($nip)
    {
        // GET /pns/data-utama/{nipBaru}

        $client = service('curlrequest');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/data-utama/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.getenv('wso.oauth2.token'),
            ],
            'verify' => false
        ]);

        echo $response->getBody();
    }
}
