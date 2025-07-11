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

    function pendidikan($nip) {
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

        return $this->response->setJSON($response->getBody());
    }

    function diklat($nip) {
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

        return $this->response->setJSON($response->getBody());
    }

    function kinerjaperiodik($nip) {
        // GET /pns/rw-kinerjaperiodik/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-kinerjaperiodik/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    function skp($nip) {
        // GET /pns/rw-skp/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-skp/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    function skp22($nip) {
        // GET /pns/rw-skp22/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-skp22/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    function potensi($nip) {
        // GET /pns/rw-skp22/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-potensi/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    function kompetensi($nip) {
        // GET /pns/rw-skp22/{nipBaru}

        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/rw-kompetensi/'.$nip, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    function datautamaupdate() {
        // POST /pns/data-utama-update

        $client = service('curlrequest');
        $cache = service('cache');
        
        $param = [
            'pns_orang_id' => $this->request->getPost('pns_orang_id'),
            'email' => $this->request->getPost('email'),
            'email_gov' => $this->request->getPost('email_gov'),
            'karis_karsu' => $this->request->getPost('karis_karsu'),
            'nomor_bpjs' => $this->request->getPost('nomor_bpjs'),
            'nomor_hp' => $this->request->getPost('nomor_hp'),
            'nomor_telpon' => $this->request->getPost('nomor_telpon'),
            'npwp_nomor' => $this->request->getPost('npwp_nomor'),
            'tapera_nomor' => $this->request->getPost('tapera_nomor'),
            'taspen_nomor' => $this->request->getPost('taspen_nomor')
        ];
        $response = $client->request('POST', getenv('wso.apisiasn.endpoint').'/pns/data-utama-update', [
            'pns' => $param,
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

}
