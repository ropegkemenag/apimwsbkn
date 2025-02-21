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
        // GET /pns/nilaiipasn/{nipBaru}

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
    
    public function photo($id)
    {
        // GET /pns/data-utama/{nipBaru}

        $client = service('curlrequest');
        // $cache = service('cache');

        // $pns = $this->datautama($id)->getBody();
        
        // $idpns = $pns->data->id;

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/photo/'.$id, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        echo $response->getBody();
    }

    public function datapasangan($nip)
    {
        // GET /pns/data-pasangan/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/data-pasangan/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    public function dataanak($nip)
    {
        // GET /pns/data-anak/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/data-anak/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    public function dataortu($nip)
    {
        // GET /pns/data-ortu/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/data-ortu/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }
}
