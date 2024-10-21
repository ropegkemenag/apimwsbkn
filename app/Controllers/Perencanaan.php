<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Perencanaan extends BaseController
{
    public function index()
    {
        //
    }

    public function formasi()
    {
        // https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd=
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/verval/menpan/list?usul_rincian_formasi_id=3a6b38a7-ec6c-4faf-ad0c-7498208d72fb&page=1', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'query' => [
                'page' => 1,
                'per_page' => 50,
                'jenis_pengadaan' => '02',
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();
    }
}
