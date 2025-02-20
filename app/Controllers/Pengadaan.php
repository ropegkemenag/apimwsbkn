<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pengadaan extends BaseController
{
    public function list()
    {
        // Penetapan NIP
        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pengadaan/list-pengadaan-instansi', [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'query' => ['tahun'=>2024],
            'verify' => false,
            'debug' => true,
        ]);

        echo $response->getBody();
    }

    public function dokumen()
    {
        // Penetapan NIP
        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pengadaan/dokumen-pengadaan', [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false,
            'debug' => true,
        ]);

        echo $response->getBody();
    }

    public function monitoring($id)
    {
        // Penetapan NIP
        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/pengadaan/usulan/monitoring/log/'.$id, [
            'headers' => [
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
            ],
            'verify' => false,
            'debug' => true,
        ]);

        echo $response->getBody();
    }
}
