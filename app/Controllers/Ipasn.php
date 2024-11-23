<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Ipasn extends BaseController
{
    public function index()
    {
        //
    }

    public function nip($nip,$tahun)
    {
        // https://api-siasn.bkn.go.id/siasn-instansi/ipasn/nilai-ip-instansi-allasn?asn=PNS&tahun=2023&limit=10&offset=0&nip=198707222019031005&nama=
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/ipasn/nilai-ip-instansi-allasn?asn=PNS&tahun='.$tahun.'&limit=10&offset=0&nip='.$nip, [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://siasn-instansi.bkn.go.id',
                'referer' => 'https://siasn-instansi.bkn.go.id/layananIP/nilaiASN',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();
    }
}
