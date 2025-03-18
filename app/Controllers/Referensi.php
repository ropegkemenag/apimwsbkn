<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Referensi extends BaseController
{
    public function index()
    {
        //
    }
    
    public function refunor() {
        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/referensi/ref-unor', [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }
}
