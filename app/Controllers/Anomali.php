<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Anomali extends BaseController
{
    public function index()
    {
        //
    }

    public function jenis()
    {
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/anomali/jenisanomaliinstitusi', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://siasn-instansi.bkn.go.id',
                'referer' => 'https://siasn-instansi.bkn.go.id/tampilanData',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token2'),
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    public function delete($id)
    {
        // DELETE /angkakredit/delete/{idRiwayatAngkaKredit}
    }

    public function save()
    {
        // POST /angkakredit/save
    }
}
