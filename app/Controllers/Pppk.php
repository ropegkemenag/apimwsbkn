<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pppk extends BaseController
{
    public function index()
    {
        return view('pppk/index');
    }

    public function sotk()
    {
        return view('pppk/ceksotk');
    }

    function search($jabatan,$penempatan,$subjabatan){
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/verval/menpan/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
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

        if($subjabatan == 'x'){
            return $this->response->setJSON($lists->data->records[0]);
        }else{
            foreach($lists->data->records as $row){
                
                if($row->nama_sub_jabatan == $subjabatan){
                    return $this->response->setJSON($row);
                    exit;
                }
            }
        }


        // return $this->response->setJSON(['id'=>'Gak ada']);
        return $this->response->setJSON($lists);

    }

    function searchsotk($unor,$jabatan,$subjabatan){
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_sotk/usul_sotk_detail/searching', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
            ],
            'query' => [
                'usul_sotk_id' => 'd9f13001-ad65-412e-a129-d744b40acba8',
                'search' => $unor
            ],
            'debug' => true,
            'verify' => false
        ]);

        $lists = json_decode($response->getBody());

        // foreach($lists->data->records as $row){
        //     if($row->nama_sub_jabatan == $subjabatan){
        //         return $this->response->setJSON($row);
        //         exit;
        //     }
        // }

        // if($lists->data->records){
        //     $child = $this->searchsotkbyatasan($lists->data->records[0]->value);
        //     return $this->response->setJSON($child);
        // }else{
        //     return $this->response->setJSON(['text'=>'Gak ada. Buatin rinciannya']);
        // }

        return $this->response->setJSON($lists);

    }

    function searchunor($penempatan){
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/verval/menpan/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
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

    function sotkdetail($sotkid) {
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_sotk/usul_sotk_detail/formasi', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
            ],
            'query' => [
                'usul_sotk_id' => 'd9f13001-ad65-412e-a129-d744b40acba8',
                'induk_unor_id' => $sotkid
            ],
            'debug' => true,
            'verify' => false
        ]);

        $lists = json_decode($response->getBody());
        // return $lists;
        return $this->response->setJSON($lists);
    }

    function searchsotkbyatasan($atasanid) {
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_sotk/usul_sotk_detail/diatasan/'.$atasanid.'?parent_id='.$atasanid.'&usul_sotk_id=d9f13001-ad65-412e-a129-d744b40acba8', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://perencanaan-sscasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
            ],
            'debug' => true,
            'verify' => false
        ]);

        $lists = json_decode($response->getBody());
        return $lists;
        // return $this->response->setJSON($lists);
    }

    function createsotk() {
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/verval/menpan/list', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://perencanaan-siasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
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

    function changekuota() {
        $client = service('curlrequest');

        $id = $this->request->getVar('id');
        $pendidikan = $this->request->getVar('pendidikan');
        $usdid = $this->request->getVar('usul_sotk_detail_id');
        $jenis_jabatan_id = $this->request->getVar('jenis_jabatan_id');
        $jabatan_fungsional_id = $this->request->getVar('jabatan_fungsional_id');
        $jenis_jabatan_umum_id = $this->request->getVar('jenis_jabatan_umum_id');
        $angka_pppk_teknis = $this->request->getVar('angka_pppk_teknis');
        $angka_pppk_guru = $this->request->getVar('angka_pppk_guru');
        $angka_pppk_nakes = $this->request->getVar('angka_pppk_nakes');

        $pendidikan = str_replace("xxx", $usdid, $pendidikan);

        $params = [
            'id' => $id,
            'penghasilan_min' => '2500000',
            'penghasilan_max' => '7000000',
            'pendidikan' => $pendidikan,
            'usul_sotk_id' => 'd9f13001-ad65-412e-a129-d744b40acba8',
            'usul_sotk_detail_id' => $usdid,
            'instansi_id' => 'A5EB03E23BFBF6A0E040640A040252AD',
            'usul_rincian_formasi_id' => '3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
            'jenis_jabatan_id' => $jenis_jabatan_id,
            'jabatan_fungsional_id' => $jabatan_fungsional_id,
            'kebutuhan_pegawai' => '5',
            'bezetting_pppk' => '1',
            'mappingPendidikan' => '1',
            'prediksi_pensiun_pppk' => '0',
            'bezetting_cpns' => '0',
            'pembina_id' => 'null',
            'prediksi_pensiun_cpns' => '0',
            'jenis_asn_id' => '02',
            'jenis_jabatan_umum_id' => $jenis_jabatan_umum_id,
            'angka_pppk_guru' => $angka_pppk_guru,
            'angka_pppk_nakes' => $angka_pppk_nakes,
            'angka_pppk_teknis' => $angka_pppk_teknis,
            'angka_cpns_guru' => '0',
            'angka_cpns_nakes' => '0',
            'angka_cpns_teknis' => '0',
            'cpns_guru' => '6992',
            'cpns_teknis' => '13780',
            'cpns_nakes' => '0',
            'cpns_total' => '20772',
            'pppk_guru' => '19437',
            'pppk_teknis' => '69842',
            'pppk_nakes' => '502',
            'pppk_total' => '89781',
            'perbaikan_menpan' => '1',
            '_method' => 'put'
        ];

        $response = $client->request('POST', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/updateRincian', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://perencanaan-siasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
            ],
            'form_params' => $params,
            'debug' => true,
            'verify' => false
        ]);

        // print_r($params);
        // print_r($response->getBody());

        $response = json_decode($response->getBody());

        return $this->response->setJSON($response);
    }

    function changependidikan($id) {
        
    }

    function deleterincian() {
        // https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/hapusRincian
        // Payload
        // id: f1e41ab8-267e-4a09-be62-6215e1902211
        // _method: put

        $client = service('curlrequest');

        $id = $this->request->getVar('idhapus');

        $response = $client->request('POST', 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail/hapusRincian', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://perencanaan-siasn.bkn.go.id',
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
            ],
            'form_params' => [
                'id' => $id,
                '_method' => 'put'
            ],
            'debug' => true,
            'verify' => false
        ]);

        $response = json_decode($response->getBody());

        return $this->response->setJSON($response);
    }
}
