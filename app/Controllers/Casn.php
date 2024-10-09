<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CasnStatSatkerModel;

class Casn extends BaseController
{
    public function index()
    {
        //
    }

    public function dashboardcpns()
    {
        // https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd=
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik', [
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

        return $this->response->setJSON($response->getBody());
    }

    public function dashboardpppk()
    {
        // https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd=
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-sscasn.bkn.go.id/2024/dashboard/pppk/statistik', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://dashboard-sscasn.bkn.go.id/',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'query' => [
                'pengadaan_kd' => 3
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    public function formasi($tahun,$offset,$limit,$id=false)
    {
        // https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd=
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-sscasn.bkn.go.id/'.$tahun.'/dashboard/cpns-new', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://dashboard-sscasn.bkn.go.id/',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'query' => [
                'offset' => $offset,
                'limit' => $limit,
                'pengadaan_kd' => $id
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();
    }

    public function store($tahun,$page,$id=false)
    {
        $limit = 100;
        
        $offset = ($page>0)?($limit*$page):0;

        $list = $this->formasi($tahun,$offset,$limit,$id);
        $lists = json_decode($list);

        // return $list;
        // echo $list->data->page->total;
        $model = new CasnStatSatkerModel;
        foreach($lists->data->data as $row){
            $param = [
                'formasi_id' => $row->formasi_id,
                'jab_nm' => $row->jab_nm,
                'jenis_formasi_nm' => $row->jenis_formasi_nm,
                'lok_formasi_nm' => $row->lok_formasi_nm,
                'jml_blm_verif' => $row->jml_blm_verif,
                'jml_formasi' => $row->jml_formasi,
                'jml_ms' => $row->jml_ms,
                'jml_pendaftar' => $row->jml_pendaftar,
                'jml_submit' => $row->jml_submit,
                'jml_tms' => $row->jml_tms,
                'updated_at' => $row->updated_at
            ];

            if($this->checkId($row->formasi_id)){
                $save = $model->save($param);
            }else{
                $save = $model->insert($param);
            }
        }

        $page = $page+1;
        if($lists->data->page->total == $limit){
            return redirect()->to('casn/store/'.$tahun.'/'.$page.'/'.$id);
        }else{
            echo 'Done';
        }

    }

    public function checkId($id)
    {
        $model = new CasnStatSatkerModel;
        $check = $model->find($id);

        return ($check)?true:false;
    }
}
