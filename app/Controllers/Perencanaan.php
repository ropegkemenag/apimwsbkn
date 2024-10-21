<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PerencanaanModel;

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
                'per_page' => 1,
                'jenis_pengadaan' => '02',
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();
    }

    function storedb() {
        // $limit = 100;
        
        // $offset = ($page>0)?($limit*$page):0;

        $list = $this->formasi();
        $lists = json_decode($list);

        // return $list;
        // echo $list->data->page->total;
        $model = new PerencanaanModel;
        foreach($lists->data->records as $row){
            $param = [
                'id' => $row->id,
                'usul_sotk_id' => $row->usul_sotk_id,
                'usul_sotk_detail_id' => $row->usul_sotk_detail_id,
                'usul_rincian_formasi_id' => $row->usul_rincian_formasi_id,
                'instansi_id' => $row->instansi_id,
                'statusRincian' => $row->statusRincian,
                'kebutuhan_pegawai' => $row->kebutuhan_pegawai,
                'penghasilan_min' => $row->penghasilan_min,
                'penghasilan_max' => $row->penghasilan_max,
                'pembina_id' => $row->pembina_id,
                'kualifikasi_guru' => $row->kualifikasi_guru,
                'pendidikan_pembina_id' => $row->pendidikan_pembina_id,
                'penghasilan' => $row->penghasilan,
                'jenis_jabatan_id' => $row->jenis_jabatan_id,
                'jabatan_fungsional_id' => $row->jabatan_fungsional_id,
                'nama_jabatan' => $row->nama_jabatan,
                'pendidikan' => $row->pendidikan,
                'pendidikan_id' => json_encode($row->pendidikan_id),
                'alokasi_formasi' => $row->alokasi_formasi,
                'jenis_jabatan_umum' => $row->jenis_jabatan_umum,
                'jenis_jabatan_umum_id' => $row->jenis_jabatan_umum_id,
                'jenis_pengadaan' => $row->jenis_pengadaan,
                'jenis_pengadaan_id' => $row->jenis_pengadaan_id,
                'unit_kerja' => $row->unit_kerja,
                'mapping_pendidikan_perencanaan_2024' => $row->mapping_pendidikan_perencanaan_2024,
                'status_verifikasi_id' => $row->status_verifikasi_id,
                'alasan_tolak' => $row->alasan_tolak,
                'total_kebutuhan' => $row->total_kebutuhan,
                'import_pembina' => $row->import_pembina,
                'prioritas_pembina' => $row->prioritas_pembina,
                'total_rincian' => $row->total_rincian,
                'sudah_verval' => $row->sudah_verval,
                'belum_verval' => $row->belum_verval,
                'status_verifikasi_menpan_id' => $row->status_verifikasi_menpan_id,
                'alasan_tolak_menpan' => $row->alasan_tolak_menpan,
                'keterangan_tolak_menpan' => $row->keterangan_tolak_menpan,
                'nama_sub_jabatan' => $row->nama_sub_jabatan,
                'setuju_menpan' => $row->setuju_menpan,
                'ditolak_menpan' => $row->ditolak_menpan,
                'diperbaiki_menpan' => $row->diperbaiki_menpan,
                'is_setuju' => $row->is_setuju,
            ];

            // if($this->checkId($row->formasi_id)){
            //     $save = $model->save($param);
            // }else{
            // }
            $save = $model->insert($param);
        }

        // $page = $page+1;
        // if($lists->data->page->total == $limit){
        //     return redirect()->to('casn/store/'.$tahun.'/'.$page.'/'.$id);
        // }else{
        // }
        echo 'Done';
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
}
