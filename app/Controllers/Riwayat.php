<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Riwayat extends BaseController
{
    public function index()
    {
        //
    }

    function jabatan($nip) {
        // GET /pns/rw-jabatan/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-jabatan/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    function golongan($nip) {
        // GET /pns/rw-golongan/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-golongan/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    public function pendidikan($nip)
    {
        // GET /pns/rw-pendidikan/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-pendidikan/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        // echo $response->getBody();
        return $this->response->setJSON($response->getBody());
    }

    public function diklat($nip)
    {
        // GET /pns/rw-diklat/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-diklat/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        // echo $response->getBody();
        return $this->response->setJSON($response->getBody());
    }
}
