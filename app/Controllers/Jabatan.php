<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Jabatan extends BaseController
{
    public function pns($nip)
    {
        // /jabatan/pns/{nipBaru}
        $client = service('curlrequest');
        $cache = service('cache');
        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/jabatan/pns/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);
        
        return $this->response->setJSON($response->getBody());
    }
}
