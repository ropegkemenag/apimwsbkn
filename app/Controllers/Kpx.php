<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KpModel;
use App\Models\SimpegModel;

class Kp extends BaseController
{
    public function index()
    {
        //
    }
    
    public function list($periode,$offset,$limit)
    {
        // GET /pns/list-kp-instansi

        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/kp/usulan/monitoring', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://dashboard-sscasn.bkn.go.id/',
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
            ],
            'query' => [
                'limit'=> $limit,
                'offset'=> $offset,
                'periode'=> $periode
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();

    }
    
    public function listx($periode)
    {
        // GET /pns/list-kp-instansi

        $client = service('curlrequest');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/list-kp-instansi', [
            'headers' => [
                'accept'            => 'application/json',
                'Auth'              => 'bearer '.service('cache')->get('auth.token'),
                'Authorization'     => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'query' => ['periode' => $periode],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();

    }
    
    public function upload()
    {
        // POST /upload-dok-sk-kp

    }
    
    public function storedb($periode,$page)
    {
        $limit = 500;
        $offset = ($page>0)?($limit*$page):0;

        $list = json_decode($this->list($periode,$offset,$limit));
        $model = new KpModel;
        $model->truncate();
        // return $this->response->setJSON($list->data);
        // print_r($list->data);

        // $smodel = new SimpegModel;

        foreach($list->data as $row){
            // $simpeg = $smodel->getPegawai($row->nipBaru);

            $param = [
                'id' => $row->id,
                'pnsId' => $row->pns_id,
                'nipBaru' => $row->nip,
                'nama' => $row->nama,
                'statusUsulan' => $row->status_usulan,
                'statusUsulanNama' => $row->keterangan,
                'no_pertek' => $row->no_pertek,
                'no_sk' => $row->no_sk,
                'tgl_sk' => ($row->tgl_sk)?date("Y-m-d", strtotime($row->tgl_sk)):'',
                'path_ttd_sk' => '',
                'tgl_pertek' => ($row->tgl_pertek)?date("Y-m-d", strtotime($row->tgl_pertek)):'',
                'path_ttd_pertek' => $row->path_ttd_pertek,
                'path_preview_sk' => '',
                'jenis_kp' => $row->detail_layanan_nama,
                'golonganBaruId' => $row->usulan_data->data->golongan_baru_id,
                'unor_induk_id' => $row->usulan_data->data->unor_induk,
                'unor_nama' => $row->usulan_data->data->unor_nama,
                'tmtKp' => $row->usulan_data->data->tmt_golongan_baru,
                // 'satker' => $simpeg->SATKER_4
            ];

            // if($this->checkId($row->id)){
            //     $save = $model->save($param);
            // }else{
                $save = $model->insert($param);
            // }

            $page = $page+1;
            if($list->meta->total == $limit){
                return redirect()->to('kp/storedb/'.$periode.'/'.$page);
            }else{
                echo 'Done';
            }
        }

        echo 'Done';

    }

    public function checkId($id)
    {
        $model = new KpModel;
        $check = $model->find($id);

        return ($check)?true:false;
    }

    public function log($id)
    {
        // https://api-siasn.bkn.go.id/siasn-instansi/kp/usulan/get-log/81be5fc9-9c5d-4b17-af6d-098381aee1c2
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/kp/usulan/get-log/'.$id, [
            'headers' => [
                'Authorization'     => 'Bearer '.service('cache')->get('auth.token'),
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://siasn-instansi.bkn.go.id',
                'referer' => 'https://siasn-instansi.bkn.go.id/layananIP/nilaiASN',
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();
    }

    
    
}
