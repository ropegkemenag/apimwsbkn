<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CasnStatSatkerModel;
use App\Models\ParuhModel;

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
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
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
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
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

        $response = $client->request('GET', 'https://api-sscasn.bkn.go.id/'.$tahun.'/dashboard/pppk', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://dashboard-sscasn.bkn.go.id/',
                'Authorization'     => 'Bearer '.getenv('wso.auth.token'),
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

    public function paruhwaktu($page)
    {
        $client = service('curlrequest');

        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/perencanaan/formasi_paruh_waktu/list_paruh_waktu', [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://dashboard-sscasn.bkn.go.id/',
                'Authorization'     => 'Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3NTU2NDA1ODMsImlhdCI6MTc1NTYwMDA3MywiYXV0aF90aW1lIjoxNzU1NTk3MzgzLCJqdGkiOiJiZmU1NWE0MC1kNWFkLTRlMDUtYjc1Ny1hNzFmYTE1N2JhZmQiLCJpc3MiOiJodHRwczovL3Nzby1zaWFzbi5ia24uZ28uaWQvYXV0aC9yZWFsbXMvcHVibGljLXNpYXNuIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6ImFmMjQxODExLTFhZTUtNDc1OS05NzBlLTRlMjI2OTBiMzM5NyIsInR5cCI6IkJlYXJlciIsImF6cCI6ImJrbi1zaWFzbi1wZXJlbmNhbmFhbiIsIm5vbmNlIjoiNzJkY2M5ZmMtMmIyMS00NTUxLTg0NWUtYzg2YTVkMDU4YWQ3Iiwic2Vzc2lvbl9zdGF0ZSI6ImZiZWMyZTgyLTJkYTctNGI1NC1hYzE1LTEwYjlkNTdmZGJkYiIsImFjciI6IjAiLCJhbGxvd2VkLW9yaWdpbnMiOlsiaHR0cDovL3BlcmVuY2FuYWFuLXNpYXNuLmJrbi5nby5pZCIsImh0dHBzOi8vcGVyZW5jYW5hYW4tc2lhc24uYmtuLmdvLmlkIiwiaHR0cDovL2xvY2FsaG9zdDo0MjAwIiwiaHR0cDovL2xvY2FsaG9zdDo4MDAwIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwIl0sInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46b3BlcmF0b3IiLCJyb2xlOmltdXQtaW5zdGFuc2k6bW9uaXRvcmluZyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46dXN1bC1wZW5nYWxpaGFuLWZvcm1hc2kiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLWluZm9qYWIiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46VFRFIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1tb25pdG9yLXBlcmVuY2FuYWFuLWtlcGVnYXdhaWFuIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW5nYWRhYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjpvcGVyYXRvci1za3BucyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpyZWtvbiIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOnR0ZSIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmltdXQtaW5zdGFuc2k6YWRtaW4iLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6cGVuZ2FsaWhhbi1rbDpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6YmF0YWxuaXA6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXBlbWVudWhhbi1rZWItcGVnYXdhaSIsInVtYV9hdXRob3JpemF0aW9uIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1ldmFqYWIiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjpwYXJhZiIsInJvbGU6c2lhc24taW5zdGFuc2k6c2trOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOmFwcHJvdmFsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1zb3RrIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjp1c3VsLXJpbmNpYW4tZm9ybWFzaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW5nYWRhYW46b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBpOnBlbmdhbGloYW4ta2w6YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOmJhdGFsbmlwOmFwcHJvdmFsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTphZG1pbi10ZW1wbGF0ZSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46cGFyYWYiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTphZG1pbjphZG1pbiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktdmFsaWRhdG9yLXN0YW5kYXIta29tcC1qYWIiXX0sInJlc291cmNlX2FjY2VzcyI6eyJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6Im9wZW5pZCBlbWFpbCBwcm9maWxlIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJuYW1lIjoiREFOVVJJIERBTlVSSSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODcwNzIyMjAxOTAzMTAwNSIsImdpdmVuX25hbWUiOiJEQU5VUkkiLCJmYW1pbHlfbmFtZSI6IkRBTlVSSSIsImVtYWlsIjoiZGFudWFsYmFudGFuaUBnbWFpbC5jb20ifQ.Yzd3idr0klx6UKEVlNvOzMzt4h8qjwtO3CETZ1CsOVNu4gaZmA2hOModO-qj3YtyzC3a2zESHgC75Qp6YSSXLAeKL5cFbC7Kl6qYYlU1ynRpottXh9RIu82uUMKSP4wVEceNORqkdnjoJ5-YJEotkmjO2lH1YmghKD8eCBW9enb79zHab6IXcLaWO78BadB6hVMNaTtL_SFM78QygBU8O4bao05aoEO7mWAluHEb4TihSVNzbShxiRB5v5ZYdFWCjsvXcOvPgl7jRlbmkwY7FFD_eMFcEv4MhpwbznTYadlBzw-dRCjsYAfiAvyU0HSd58tAqszMPMYXC-gI-vThjw',
            ],
            'query' => [
                'instansi_id' => 'A5EB03E23BFBF6A0E040640A040252AD',
                'page' => $page,
                'prioritas' => 2,
                'mapping' => '00',
            ],
            'debug' => true,
            'verify' => false
        ]);

        $list = $response->getBody();

        $lists = json_decode($list);

        $model = new ParuhModel;
        foreach($lists->data->records as $row){
            $param = [
                'nik' => $row->nik,
                'nama' => $row->nama,
                'jenis_kelamin' => $row->jenis_kelamin,
                'cepat_kode_sscn' => $row->cepat_kode_sscn,
                'instansi_sscn' => $row->instansi_sscn,
                'jenis_pengadaan_id' => $row->jenis_pengadaan_id,
                'jabatan_siasn_id' => $row->jenis_pengadaan_id,
                'kode_jabatan_sscn' => $row->kode_jabatan_sscn,
                'jabatan_sscn' => $row->jabatan_sscn,
                'kode_pendidikan_sscn' => $row->kode_pendidikan_sscn,
                'pendidikan_sscn' => $row->pendidikan_sscn,
                'lokasi_formasi_sscn' => $row->lokasi_formasi_sscn,
                'usia_saat_daftar_sscn' => $row->usia_saat_daftar_sscn,
                'tahap_sscn' =>  $row->tahap_sscn,
                'is_tampungan_sscn' => $row->is_tampungan_sscn,
                'cepat_kode_nonasn' => $row->cepat_kode_nonasn,
                'instansi_non_asn' => $row->instansi_non_asn,
                'unor_id_nonasn' => $row->unor_id_nonasn,
                'unor_nama_nonasn' => $row->unor_nama_nonasn,
                'pendidikan_nama_nonasn' => $row->pendidikan_nama_nonasn,
                'kode_jabatan_nonasn' => $row->kode_jabatan_nonasn,
                'jabatan_nonasn' => $row->jabatan_nonasn,
                'status_aktif_nonasn' => $row->status_aktif_nonasn,
                'updated_at' => $row->updated_at,
                'jabatan_rincian_id' => $row->jabatan_rincian_id,
                'jabatan_rincian_nama' => $row->jabatan_rincian_nama,
                'sub_jabatan_rincian_id' => $row->sub_jabatan_rincian_id,
                'sub_jabatan_rincian_nama' => $row->sub_jabatan_rincian_nama,
                'rincian_pendidikan_id' => $row->rincian_pendidikan_id,
                'rincian_pendidikan_nama' => $row->rincian_pendidikan_nama,
                'rincian_tk_pendidikan' => $row->rincian_tk_pendidikan,
                'unit_penempatan_id' => $row->unit_penempatan_id,
                'unit_penempatan_nama' => $row->unit_penempatan_nama,
                'is_terdata_nonasn' => $row->is_terdata_nonasn,
                'status_prioritas' => $row->status_prioritas,
                'sync_siasn' => NULL,
                // 'is_usul' => $row->is_usul,
                // 'alasan_tolak' => $row->alasan_tolak
            ];

            // $check = $model->find($row->nik);
            // if(!$check){
            // }
            $save = $model->save($param);
        }

        $page = $page+1;
        if($lists->data->pagination->last_page < 125){
            return redirect()->to('casn/paruhwaktu/'.$page);
        }else{
            echo 'Done';
        }

    }

    function setparuhwaktu(){
        // POST https://api-siasn.bkn.go.id/perencanaan/formasi_paruh_waktu/update_paruh_waktu
        // status_usulan : 1
        // alasan_tidak_diusulkan : jenis_pengadaan
        // teknis :
        // pendidikan_id : 0E7FA32614D38672E060640AF1083075
        // unor_id : 46e51456-62ec-43c3-8bf9-9318b043afff
        // user_id : af241811-1ae5-4759-970e-4e22690b3397
        // jabatan_id :
        // data_ids : 3674066501920004
        // usul_sotk_id : d9f13001-ad65-412e-a129-d744b40acba8
        // jenis : P

        $client = service('curlrequest');

        // $form = $this->request->getVar();

        $response = $client->request('POST', 'https://api-siasn.bkn.go.id/perencanaan/formasi_paruh_waktu/update_paruh_waktu', [
            'headers' => [
                'Origin' => null,
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Cookie'     => '_ga=GA1.1.1409040940.1726985318; _ga_5GQ07M1DL1=GS1.1.1729584198.3.1.1729584220.0.0.0; _ga_NVRKS9CPBG=GS1.1.1729597976.14.0.1729597976.0.0.0; BIGipServerpool_prod_sscasn2024_kube=3154600970.47873.0000; 9760101acce488cfa3a2041bbb8bb77f=ac978f6657646bddd4c30510616f0898; JSESSIONID=58DFA0AA1F244DBD78450618BF158E12; OAuth_Token_Request_State=7b1d214e-89ab-4e1c-9245-c9e7618d642b; _ga_THXT2YWNHR=GS1.1.1730096260.14.0.1730096262.0.0.0',
            ],
            'form_params' => [
                'status_usulan' => 1,
                'alasan_tidak_diusulkan' => 'jenis_pengadaan',
                'pendidikan_id' => '0E7FA32614D38672E060640AF1083075',
                'unor_id' => '46e51456-62ec-43c3-8bf9-9318b043afff',
                'user_id' => 'af241811-1ae5-4759-970e-4e22690b3397',
                'jabatan_id' => '',
                'data_ids' => '3674066501920004',
                'usul_sotk_id' => 'd9f13001-ad65-412e-a129-d744b40acba8',
                'jenis' => 'P'
            ],
            'debug' => true,
            'verify' => false
        ]);

        $response = json_decode($response->getBody());

        return $this->response->setJSON($response);

        // respon
        /*
        {
            "respon_status": {
                "status": "SUCCESS",
                "code": 200,
                "message": "Data berhasil diperbarui"
            }
        }
        */
    }
}
