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
    
    public function list($periode)
    {
        // GET /pns/list-kp-instansi

        $client = service('curlrequest');

        $response = $client->request('GET', getenv('wso.apisiasn.endpoint').'/pns/list-kp-instansi', [
            'headers' => [
                'accept'            => 'application/json',
                'Auth'              => 'bearer '.getenv('wso.auth.token'),
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
    
    public function storedb($periode)
    {
        $list = json_decode($this->list($periode));
        $model = new KpModel;
        $model->truncate();
        // return $this->response->setJSON($list->data);
        // print_r($list->data);

        // $smodel = new SimpegModel;

        foreach($list->data as $row){
            // $simpeg = $smodel->getPegawai($row->nipBaru);

            $param = [
                'id' => $row->id,
                'pnsId' => $row->pnsId,
                'nipBaru' => $row->nipBaru,
                'nama' => $row->nama,
                'statusUsulan' => $row->statusUsulan,
                'statusUsulanNama' => $row->statusUsulanNama,
                'no_pertek' => $row->no_pertek,
                'no_sk' => $row->no_sk,
                'tgl_sk' => ($row->tgl_sk)?date("Y-m-d", strtotime($row->tgl_sk)):'',
                'path_ttd_sk' => $row->path_ttd_sk,
                'tgl_pertek' => ($row->tgl_pertek)?date("Y-m-d", strtotime($row->tgl_pertek)):'',
                'path_ttd_pertek' => $row->path_ttd_pertek,
                'path_preview_sk' => $row->path_preview_sk,
                'jenis_kp' => $row->jenis_kp,
                'golonganBaruId' => $row->golonganBaruId,
                'unor_induk_id' => $row->unor_induk_id,
                'unor_nama' => $row->unor_nama,
                'tmtKp' => $row->tmtKp,
                // 'satker' => $simpeg->SATKER_4
            ];

            // if($this->checkId($row->id)){
            //     $save = $model->save($param);
            // }else{
                $save = $model->insert($param);
            // }
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
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
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
