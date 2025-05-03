<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pengadaan extends BaseController
{
    public function list($tahun,$limit,$offset)
    {
        // Penetapan NIP
        $client = service('curlrequest');
        $cache = service('cache');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pengadaan/list-pengadaan-instansi', [
            'headers' => [
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'query' => ['tahun'=>$tahun,'limit'=>$limit,'offset'=>$offset],
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
                'Authorization'     => 'Bearer '.getenv('wso.auth.tokentest'),
            ],
            'verify' => false,
            'debug' => true,
        ]);

        echo $response->getBody();
    }

    function siasn($tahun,$jenis,$limit,$offset) {
        // https://api-siasn.bkn.go.id/siasn-instansi/pengadaan/usulan/monitoring?no_peserta=&nama=&tgl_usulan=&jenis_pengadaan_id=01&jenis_formasi_id=&status_usulan=&periode=2024&limit=10&offset=0
    
        $client = service('curlrequest');
        $cache = service('cache');

        // $limit = 10;
        // $offset = 0;

        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/pengadaan/usulan/monitoring?jenis_pengadaan_id='.$jenis.'&status_usulan=&periode='.$tahun.'&limit='.$limit.'&offset='.$offset, [
            'headers' => [
                'Authorization'     => 'Bearer '.getenv('wso.auth.tokentest'),
            ],
            'verify' => false,
            'debug' => true,
        ]);

        // echo $response->getBody();
        return $this->response->setJSON( $response->getBody() );
    }

    function usulan($tahun,$jenis,$limit,$offset) {
        
        $usulan = $this->siasn($tahun,$jenis,$limit,$offset);
        // $usulan = json_decode($usulan, true);
        // $usulan = $usulan['data'];

        $datas = json_decode($usulan->getBody());
        $meta = $datas->meta;
        $data = $datas->data;
        $page = $datas->page;

        $total = $meta->total;
        // $totalPage = ceil($total / $limit);
        // $nextPage = $page + 1;
        
        echo $total;
        
    }
}
