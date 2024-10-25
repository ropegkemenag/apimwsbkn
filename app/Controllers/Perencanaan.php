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

    public function getsubjabatan($id_formasi, $usul_sotk_detail_id)
    {
        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://perencanaan-siasn.bkn.go.id/api/usul_anjab/usul_rincian_formasi_detail?usul_sotk_id=d9f13001-ad65-412e-a129-d744b40acba8&usul_sotk_detail_id='.($usul_sotk_detail_id).'&usul_rincian_formasi_id=3a6b38a7-ec6c-4faf-ad0c-7498208d72fb&page=1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8',
                'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3Mjk4Njg2MjQsImlhdCI6MTcyOTgyNTQyNCwianRpIjoiMmE3ZDVjYTQtZjM0Ni00YTRkLWE3YjEtNDFmMzkwMDg1NGM4IiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsImF1ZCI6ImFjY291bnQiLCJzdWIiOiJhZjI0MTgxMS0xYWU1LTQ3NTktOTcwZS00ZTIyNjkwYjMzOTciLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJrZW1lbmFnY2xpZW50Iiwic2Vzc2lvbl9zdGF0ZSI6ImU1M2Y3ZTZiLWExMzktNDY0Ny1hZWRkLTRkY2FlZTcyZjU5NiIsImFjciI6IjEiLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1pbmZvamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktbW9uaXRvci1wZXJlbmNhbmFhbi1rZXBlZ2F3YWlhbiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOmFwcHJvdmFsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTprcDphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOlRURSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpyZWtvbiIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOmRhc2hib2FyZC1rZWJpamFrYW46aW5zdGFuc2kiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6YmF0YWxuaXA6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXBlbWVudWhhbi1rZWItcGVnYXdhaSIsInVtYV9hdXRob3JpemF0aW9uIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLWV2YWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOnBhcmFmIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpza2s6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXNvdGsiLCJyb2xlOmRhc2hib2FyZC1vcGVyYXNpb25hbDppbnN0YW5zaSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46dXN1bC1yaW5jaWFuLWZvcm1hc2kiLCJyb2xlOmRpc3Bha2F0aTppbnN0YW5zaTpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVuZ2FkYWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW1iZXJoZW50aWFuOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwaTphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6YmF0YWxuaXA6YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLXBlbWJpbmEtcHBrIiwicm9sZTpzaWFzbi1pbnN0YW5zaTppcGFzbjptb25pdG9yaW5nIiwicm9sZTpzaWFzbi1pbnN0YW5zaTphZG1pbi10ZW1wbGF0ZSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVtYmVyaGVudGlhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpkYXNoYm9hcmQtb3BlcmFzaW9uYWw6aW5zdGFuc2ktcGltcGluYW4iLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoiZW1haWwgcHJvZmlsZSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwibmFtZSI6IkRBTlVSSSBEQU5VUkkiLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiIxOTg3MDcyMjIwMTkwMzEwMDUiLCJnaXZlbl9uYW1lIjoiREFOVVJJIiwiZmFtaWx5X25hbWUiOiJEQU5VUkkiLCJlbWFpbCI6ImRhbnVhbGJhbnRhbmlAZ21haWwuY29tIn0.LWPQZuY3tV23SU5nHzWMqemrNNmMthho1w9zR12DbRrfXixFt3Le6fYNEzFN6zaguLX7eec49UU-50qZJyrZZR738UP4V5dhFlVkXKStGyfGQjF55sNA03PsLMOiBzc7IS00s104Iq2B03AtowCb7pqy6xE3X3Zhu3u1iwib_vDRcW2qV8GrCHzo3RLFafZfNBTnmxc9idv15TLziQAezMVbM3n2JqAT7gh3cwAwpQsdlCfSLLbWc_ZXtHf9jXEoKEsJbxQpR6me17HAc-9mOK0EVDpDdq0hJ973hmGnOTOxTSOBy1rQJVRWTtpXxv44xqIiB_zy1KTZUy8ej2aH_Q',
                'Connection: keep-alive',
                'Cookie: _ga=GA1.1.1741991209.1727313365; _ga_6L51PKND1M=GS1.1.1728818670.1.1.1728818706.0.0.0; _ga_THXT2YWNHR=GS1.1.1728818739.7.0.1728818741.0.0.0; _ga_5GQ07M1DL1=GS1.1.1728955905.5.0.1728955905.0.0.0; BIGipServerpool_perencanaan_siasn=1560830986.47873.0000; b7de4f5ca78af8ff43fe9a3ad2da4208=fe71bd9f835e8e2d19c178bdb9dc4d01; XSRF-TOKEN=eyJpdiI6Ik9udURlQnVYNlRrcnB0Unk1MlVZUkE9PSIsInZhbHVlIjoiT2Z5ZnovbjZMZGZTTHI3ZWN1VERCeXB3bmo3cURYb1p0TlJBYk9OSzh6QjhidnBpK2FZSFRGVlByTVJtMVlpbHprcWZ1ZjVSUVRtNHdvTHFKWGxDaEJmV2oyd0t1dERIRGpKNTlBWk1zQktxbk1veXlmeVpIRWxaNWpENFJ0cVIiLCJtYWMiOiIzZWZkZWU5ZDNlY2U4NDhhNmQ0YjNjMjFkZDU5MmVkY2Q5ZjIyNmRhMGJiZTRkYzNjYzJhN2ViMzM3ZGI1NDQzIiwidGFnIjoiIn0%3D; api_layanan_perencanaan_session=eyJpdiI6IlBoakhyMEI5UmU4ZzNKWDhNcVhlWXc9PSIsInZhbHVlIjoiZmNmTTBkZFBvemtQajFVSmVWV1ZIK25HL0Vjd0pWM3IvTkhMMUJxbStTcjMvTFdRYWNCRERuTEhFTVAxQnl4bHlBZ1luUnJSWmhEcElBTDdtME4vcmc0akE4N056bGVMVlVpNllpd3hyVjBKaVhiY0ZtRmtOcjYrRDU4ZkE1OHgiLCJtYWMiOiJhM2FkZDQzZjRmYjRiYTY5YzA1NmMwNDAzZGMwNDBkNmVlZDlmMDA0ZjkwNjg4ODRjZjdlZTFlNmVjOGFlNTc4IiwidGFnIjoiIn0%3D; b7de4f5ca78af8ff43fe9a3ad2da4208=e925b7170a9d8aaf57583f1dc937a67c',
                'Origin: https://perencanaan-siasn.bkn.go.id',
                'Referer: https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',
                'X-XSRF-TOKEN: eyJpdiI6Ik9udURlQnVYNlRrcnB0Unk1MlVZUkE9PSIsInZhbHVlIjoiT2Z5ZnovbjZMZGZTTHI3ZWN1VERCeXB3bmo3cURYb1p0TlJBYk9OSzh6QjhidnBpK2FZSFRGVlByTVJtMVlpbHprcWZ1ZjVSUVRtNHdvTHFKWGxDaEJmV2oyd0t1dERIRGpKNTlBWk1zQktxbk1veXlmeVpIRWxaNWpENFJ0cVIiLCJtYWMiOiIzZWZkZWU5ZDNlY2U4NDhhNmQ0YjNjMjFkZDU5MmVkY2Q5ZjIyNmRhMGJiZTRkYzNjYzJhN2ViMzM3ZGI1NDQzIiwidGFnIjoiIn0=',
                'sec-ch-ua: "Google Chrome";v="129", "Not=A?Brand";v="8", "Chromium";v="129"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"'
            ),
            ));

            $response = curl_exec($curl);
            $formasinya = [];
            curl_close($curl);

            $formasi = json_decode($response)->data->records;

            foreach ($formasi as $key => $value) {
                if($value->id == $id_formasi){

                    $formasinya = $value;
                    
                }
            }

        return $this->response->setJSON($formasinya->nama_sub_jabatan);
    }
}
