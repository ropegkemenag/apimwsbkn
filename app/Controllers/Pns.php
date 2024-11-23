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
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/data-utama/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        // echo $response->getBody();
        return $this->response->setJSON($response->getBody());
    }
    
    public function ipasn($nip)
    {
        // GET /pns/data-utama/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/nilaiipasn/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        // echo $response->getBody();
        return $this->response->setJSON($response->getBody());
    }
    
    public function photo($nip)
    {
        // GET /pns/data-utama/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $pns = $this->datautama($nip);
        print_r($pns);
        return false;
        $idpns = $pns->data->id;

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/photo/'.$idpns, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        echo $response->getBody();
    }
}
