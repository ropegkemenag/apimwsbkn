<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Casn extends BaseController
{
    public function index()
    {
        //
    }

    public function dashboard($id=false)
    {
        // https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd=
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd='.$id, [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://dashboard-sscasn.bkn.go.id/',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();
    }
}
