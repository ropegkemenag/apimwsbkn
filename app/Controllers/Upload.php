<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Upload extends BaseController
{
    public function index()
    {
        //
    }

    public function download()
    {
        // GET /download-dok
        $path = $this->request->getGet('path');
        $fname = $this->request->getGet('fname');
        $client = service('curlrequest');
        $cache = service('cache');
        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/download-dok?filePath='.$path, [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'verify' => false,
            'debug' => true,
        ]);
        // echo $response->getBody();
        // return $this->response->setJSON($response->getBody());
        return $this->response->download($fname, $response->getBody());
    }

    public function dok()
    {
        // POST /upload-dok
    }

    public function dokrw()
    {
        // POST /upload-dok-rw
    }
}
