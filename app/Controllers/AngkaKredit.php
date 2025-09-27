<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Angkakredit extends BaseController
{
    public function index()
    {
        //
    }

    public function getid($id)
    {
        // GET /angkakredit/id/{idRiwayatAngkaKredit}
        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/angkakredit/id/'.$id, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
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
