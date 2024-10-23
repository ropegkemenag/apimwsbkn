<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pppk extends BaseController
{
    public function index()
    {
        //
    }

    function search($jabatan,$penempatan){
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/verval/menpan/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'query' => [
                'usul_rincian_formasi_id' => '3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'page' => 1,
                'jenis_pengadaan' => '02',
                'jabatan' => $jabatan,
                'penempatan' => $penempatan,
            ],
            'debug' => true,
            'verify' => false
        ]);

        $lists = json_decode($response->getBody());

        foreach($lists->data->records as $row){
            if($row->unit_kerja == $penempatan){
                return $this->response->setJSON($row);
                exit;
            }
        }

        return $this->response->setJSON(['error'=>true]);
        // return $this->response->setJSON($lists);

    }

    function searchunor($penempatan){
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/verval/menpan/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'query' => [
                'usul_rincian_formasi_id' => '3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'page' => 1,
                'jenis_pengadaan' => '02',
                'penempatan' => $penempatan,
            ],
            'debug' => true,
            'verify' => false
        ]);

        $lists = json_decode($response->getBody());

        // return $this->response->setJSON($lists->data->records[0]);
        echo $lists->data->records[0]->unit_kerja;

    }

    function createsotk() {
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/verval/menpan/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://perencanaan-siasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'query' => [
                'usul_rincian_formasi_id' => '3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'page' => 1,
                'jenis_pengadaan' => '02',
                'jabatan' => $jabatan,
                'penempatan' => $penempatan,
            ],
            'debug' => true,
            'verify' => false
        ]);
    }

    function changekuota($id) {
        
    }

    function changependidikan($id) {
        
    }

    function delete($id) {
        
    }
}
