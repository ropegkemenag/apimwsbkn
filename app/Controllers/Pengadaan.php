<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsulModel;
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

    function downloadusul($tahun,$limit,$offset) {
        $client = service('curlrequest');
        $cache = service('cache');
  
        // $token = $cache->get('siasn_token');
        $token = 'eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3NDY2NDYzMDMsImlhdCI6MTc0NjYwMzEyNSwiYXV0aF90aW1lIjoxNzQ2NjAzMTAzLCJqdGkiOiJlYmVmODA4OC1iNGE5LTQwNDctYTc2Yi1jNGM3N2Q0MmUzNDciLCJpc3MiOiJodHRwczovL3Nzby1zaWFzbi5ia24uZ28uaWQvYXV0aC9yZWFsbXMvcHVibGljLXNpYXNuIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6ImFmMjQxODExLTFhZTUtNDc1OS05NzBlLTRlMjI2OTBiMzM5NyIsInR5cCI6IkJlYXJlciIsImF6cCI6InNpYXNuLWluc3RhbnNpIiwibm9uY2UiOiJlNzMyMGQ2ZC03YzE0LTQyZGQtODhjOC01YWQ3MDc1YjgyZWEiLCJzZXNzaW9uX3N0YXRlIjoiNWMxOTRkNTgtNzEwZS00NWU4LWFjZGUtYmE0YjkzN2ZkOTJmIiwiYWNyIjoiMCIsImFsbG93ZWQtb3JpZ2lucyI6WyJodHRwczovL3NpYXNuLWluc3RhbnNpLmJrbi5nby5pZCIsImh0dHA6Ly9zaWFzbi1pbnN0YW5zaS5ia24uZ28uaWQiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46dXN1bC1wZW5nYWxpaGFuLWZvcm1hc2kiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLWluZm9qYWIiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46VFRFIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1tb25pdG9yLXBlcmVuY2FuYWFuLWtlcGVnYXdhaWFuIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW5nYWRhYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjpvcGVyYXRvci1za3BucyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpyZWtvbiIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6cGVuZ2FsaWhhbi1rbDpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6YmF0YWxuaXA6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXBlbWVudWhhbi1rZWItcGVnYXdhaSIsInVtYV9hdXRob3JpemF0aW9uIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1ldmFqYWIiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjpwYXJhZiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjphcHByb3ZhbCIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc290ayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46dXN1bC1yaW5jaWFuLWZvcm1hc2kiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6YmF0YWxuaXA6YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluLXRlbXBsYXRlIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1zdGFuZGFyLWtvbXAtamFiIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1wZW5ldGFwYW4tc290ayIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpwYXJhZiIsInJvbGU6c2lhc24taW5zdGFuc2k6cHJvZmlsYXNuOnZpZXdwcm9maWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOmFkbWluOmFkbWluIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS12YWxpZGF0b3Itc3RhbmRhci1rb21wLWphYiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoib3BlbmlkIGVtYWlsIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJEQU5VUkkgREFOVVJJIiwicHJlZmVycmVkX3VzZXJuYW1lIjoiMTk4NzA3MjIyMDE5MDMxMDA1IiwiZ2l2ZW5fbmFtZSI6IkRBTlVSSSIsImZhbWlseV9uYW1lIjoiREFOVVJJIiwiZW1haWwiOiJkYW51YWxiYW50YW5pQGdtYWlsLmNvbSJ9.QnZGK-Li_ZnJAZY6UOq5oMeWFBW84JeQfxg7domp3YaqIeLzV_NldNYdamgS92SbnlEVNapiStjKvJpnj_WQ6PrW_7Gw_yjTg3Y5DNd8g3s94HzG0qBwl3mygLvre9e15kPmZ-L9fmmH4qAxW9_sjVrRcM0ROUJVt8aslR3JfkFAQIhFKXtkYrS65fv2PHObT0_r3zukAd7CDCIh-5GEcmhM9djl2F6KE4QwO0rN-TUI35prTmrM65xKIY86nX5CI--RnAy7Wv9fDDceQLc95hdqVZu8ZO2w7TSzUccofgqqe82V8QXrPli-dAHgvo5zkDFEKgr-g9y6gz8KLqhwXQ';
  
        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/pengadaan/usulan/monitoring?status_usulan=&periode='.$tahun.'&limit='.$limit.'&offset='.$offset, [
            'headers' => [
                'Authorization'     => 'Bearer '.$token,
            ],
            'verify' => false,
            'debug' => true,
        ]);
        
        $model = new UsulModel;
        $data = json_decode($response->getBody());
  
        foreach ($data->data as $row) {
            $id = $row->id;
            
            $param = [
                'id' => $row->id,
                'orang_id' => $row->orang_id,
                'formasi_jumlah' => $row->usulan_data->data->formasi_jumlah,
                'formasi_lebih' => $row->usulan_data->data->formasi_lebih,
                'formasi_sisa' => $row->usulan_data->data->formasi_sisa,
                'gaji_pokok' => $row->usulan_data->data->gaji_pokok,
                'glr_belakang' => $row->usulan_data->data->glr_belakang,
                'glr_depan' => $row->usulan_data->data->glr_depan,
                'golongan_id' => $row->usulan_data->data->golongan_id,
                'golongan_nama' => $row->usulan_data->data->golongan_nama,
                'instansi_induk_id' => $row->usulan_data->data->instansi_induk_id,
                'instansi_induk_nama' => $row->usulan_data->data->instansi_induk_nama,
                'instansi_kerja_id' => $row->usulan_data->data->instansi_kerja_id,
                'instansi_kerja_nama' => $row->usulan_data->data->instansi_kerja_nama,
                'jabatan_fungsional_id' => $row->usulan_data->data->jabatan_fungsional_id,
                'jabatan_fungsional_nama' => $row->usulan_data->data->jabatan_fungsional_nama,
                'jabatan_fungsional_umum_id' => $row->usulan_data->data->jabatan_fungsional_umum_id,
                'jabatan_fungsional_umum_nama' => $row->usulan_data->data->jabatan_fungsional_umum_nama,
                'jabatan_struktural_nama' => $row->usulan_data->data->jabatan_struktural_nama,
                'jenis_jabatan_id' => $row->usulan_data->data->jenis_jabatan_id,
                'jenis_jabatan_nama' => $row->usulan_data->data->jenis_jabatan_nama,
                'jenis_masa_kerja' => $row->usulan_data->data->jenis_masa_kerja,
                'kanreg_id' => $row->usulan_data->data->kanreg_id,
                'kanreg_nama' => $row->usulan_data->data->kanreg_nama,
                'ket_bebas_narkoba_nomor' => $row->usulan_data->data->ket_bebas_narkoba_nomor,
                'ket_bebas_narkoba_pejabat' => $row->usulan_data->data->ket_bebas_narkoba_pejabat,
                'ket_bebas_narkoba_tanggal' => $row->usulan_data->data->ket_bebas_narkoba_tanggal,
                'ket_kelakuanbaik_nomor' => $row->usulan_data->data->ket_kelakuanbaik_nomor,
                'ket_kelakuanbaik_pejabat' => $row->usulan_data->data->ket_kelakuanbaik_pejabat,
                'ket_kelakuanbaik_tanggal' => $row->usulan_data->data->ket_kelakuanbaik_tanggal,
                'ket_sehat_dokter' => $row->usulan_data->data->ket_sehat_dokter,
                'ket_sehat_nomor' => $row->usulan_data->data->ket_sehat_nomor,
                'ket_sehat_tanggal' => $row->usulan_data->data->ket_sehat_tanggal,
                'kpkn_id' => $row->usulan_data->data->kpkn_id,
                'kpkn_nama' => $row->usulan_data->data->kpkn_nama,
                'lokasi_id' => $row->usulan_data->data->lokasi_id,
                'lokasi_nama' => $row->usulan_data->data->lokasi_nama,
                'masa_kerja_bulan' => $row->usulan_data->data->masa_kerja_bulan,
                'masa_kerja_bulan_pmk' => $row->usulan_data->data->masa_kerja_bulan_pmk,
                'masa_kerja_tahun' => $row->usulan_data->data->masa_kerja_tahun,
                'masa_kerja_tahun_pmk' => $row->usulan_data->data->masa_kerja_tahun_pmk,
                'nama' => $row->usulan_data->data->nama,
                'nama_sek' => $row->usulan_data->data->nama_sek,
                'no_peserta' => $row->usulan_data->data->no_peserta,
                'nomor_ijazah' => $row->usulan_data->data->nomor_ijazah,
                'orang_id' => $row->usulan_data->data->orang_id,
                'pendidikan_ijazah_nama' => $row->usulan_data->data->pendidikan_ijazah_nama,
                'pendidikan_pertama_id' => $row->usulan_data->data->pendidikan_pertama_id,
                'pendidikan_pertama_nama' => $row->usulan_data->data->pendidikan_pertama_nama,
                'satuan_kerja_id' => $row->usulan_data->data->satuan_kerja_id,
                'satuan_kerja_induk_id' => $row->usulan_data->data->satuan_kerja_induk_id,
                'satuan_kerja_induk_nama' => $row->usulan_data->data->satuan_kerja_induk_nama,
                'satuan_kerja_nama' => $row->usulan_data->data->satuan_kerja_nama,
                'satuan_kerja_induk_nama' => $row->usulan_data->data->satuan_kerja_induk_nama,
                'sub_jabatan_fungsional_id' => $row->usulan_data->data->sub_jabatan_fungsional_id,
                'sub_jabatan_fungsional_nama' => $row->usulan_data->data->sub_jabatan_fungsional_nama,
                'tahun_gaji' => $row->usulan_data->data->tahun_gaji,
                'tahun_lulus' => $row->usulan_data->data->tahun_lulus,
                'tahun_masa_kerja' => $row->usulan_data->data->tahun_masa_kerja,
                'tempat_lahir' => $row->usulan_data->data->tempat_lahir,
                'tgl_akhir_masa_kerja' => $row->usulan_data->data->tgl_akhir_masa_kerja,
                'tgl_awal_masa_kerja' => $row->usulan_data->data->tgl_awal_masa_kerja,
                'tgl_kontrak_akhir' => $row->usulan_data->data->tgl_kontrak_akhir,
                'tgl_kontrak_mulai' => $row->usulan_data->data->tgl_kontrak_mulai,
                'tgl_lahir' => $row->usulan_data->data->tgl_lahir,
                'tgl_tahun_lulus' => $row->usulan_data->data->tgl_tahun_lulus,
                'tk_pendidikan_id' => $row->usulan_data->data->tk_pendidikan_id,
                'tmt_cpns' => $row->usulan_data->data->tmt_cpns,
                'unor_id' => $row->usulan_data->data->unor_id,
                'unor_induk' => $row->usulan_data->data->unor_induk,
                'unor_induk_nama' => $row->usulan_data->data->unor_induk_nama,
                'unor_nama' => $row->usulan_data->data->unor_nama,
                'status_usulan' => $row->status_usulan,
                'tgl_usulan' => $row->tgl_usulan,
                'tgl_pengiriman_kelayanan' => $row->tgl_pengiriman_kelayanan,
                'tgl_update_layanan' => $row->tgl_update_layanan,
                'instansi_id' => $row->instansi_id,
                'keterangan' => $row->keterangan,
                'status_aktif' => $row->status_aktif,
                'no_surat_usulan' => $row->no_surat_usulan,
                'status_paraf_pertek' => $row->status_paraf_pertek,
                'status_ttd_paraf_pertek' => $row->status_ttd_paraf_pertek,
                'provinsi_nama' => $row->provinsi_nama,
                'nip' => $row->nip,
                'nama' => $row->nama,
                'instansi_nama' => $row->instansi_nama,
                'jenis_layanan_nama' => $row->jenis_layanan_nama,
                'tgl_surat_usulan' => $row->tgl_surat_usulan,
                'no_pertek' => $row->no_pertek,
                'tgl_pertek' => $row->tgl_pertek,
                'path_pertek' => $row->path_pertek,
                'path_ttd_pertek' => $row->path_ttd_pertek,
                'no_sk' => $row->no_sk,
                'tgl_sk' => $row->tgl_sk,
                'path_ttd_sk' => $row->path_ttd_sk,
                'pejabat_ttd_sk' => $row->pejabat_ttd_sk,
                'status_ttd_sk' => $row->status_ttd_sk,
                'alasan_tolak_id' => $row->alasan_tolak_id,
                'alasan_tolak_tambahan' => $row->alasan_tolak_tambahan,
                'periode' => $row->periode,
                'jenis_formasi_id' => $row->jenis_formasi_id,
                'jenis_formasi_nama' => $row->jenis_formasi_nama,
                'jenis_pegawai_id' => $row->jenis_pegawai_id,
            ];

            $model->insert($param);
        }
    }
    
}
