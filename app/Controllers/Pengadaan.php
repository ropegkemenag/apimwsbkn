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
        $token = 'eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3NDgwMjc1ODcsImlhdCI6MTc0Nzk4NDM5MywiYXV0aF90aW1lIjoxNzQ3OTg0Mzg3LCJqdGkiOiI1M2M0OTc3ZC1kMDBjLTQ4NGItODVmOC0wYWUxMGY1ZTdjNWQiLCJpc3MiOiJodHRwczovL3Nzby1zaWFzbi5ia24uZ28uaWQvYXV0aC9yZWFsbXMvcHVibGljLXNpYXNuIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6ImFmMjQxODExLTFhZTUtNDc1OS05NzBlLTRlMjI2OTBiMzM5NyIsInR5cCI6IkJlYXJlciIsImF6cCI6InNpYXNuLWluc3RhbnNpIiwibm9uY2UiOiI5MmU5MmRiYS02YWQ0LTQyMjUtYmYzNS00MjNhNTNjNTdlZTgiLCJzZXNzaW9uX3N0YXRlIjoiODA3NDc4NDEtYjhlZi00ZTVjLWI2YzgtZjQzZWQ2Y2JjMWY1IiwiYWNyIjoiMCIsImFsbG93ZWQtb3JpZ2lucyI6WyJodHRwczovL3NpYXNuLWluc3RhbnNpLmJrbi5nby5pZCIsImh0dHA6Ly9zaWFzbi1pbnN0YW5zaS5ia24uZ28uaWQiLCJodHRwOi8vbG9jYWxob3N0OjMwMDAiXSwicmVhbG1fYWNjZXNzIjp7InJvbGVzIjpbInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46dXN1bC1wZW5nYWxpaGFuLWZvcm1hc2kiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLWluZm9qYWIiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46VFRFIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1tb25pdG9yLXBlcmVuY2FuYWFuLWtlcGVnYXdhaWFuIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW5nYWRhYW46YXBwcm92YWwiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjpvcGVyYXRvci1za3BucyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW1hamFhbjpyZWtvbiIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOnR0ZSIsInJvbGU6c2lhc24taW5zdGFuc2k6a3A6b3BlcmF0b3IiLCJyb2xlOm1hbmFqZW1lbi13czpkZXZlbG9wZXIiLCJvZmZsaW5lX2FjY2VzcyIsInJvbGU6c2lhc24taW5zdGFuc2k6cGk6cGVuZ2FsaWhhbi1rbDpvcGVyYXRvciIsInJvbGU6c2lhc24taW5zdGFuc2k6YmF0YWxuaXA6b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVuY2FuYWFuOmluc3RhbnNpLW9wZXJhdG9yLXBlbWVudWhhbi1rZWItcGVnYXdhaSIsInVtYV9hdXRob3JpemF0aW9uIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1ldmFqYWIiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlbmdhZGFhbjpwYXJhZiIsInJvbGU6c2lhc24taW5zdGFuc2k6c2trOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbWFqYWFuOmFwcHJvdmFsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjppbnN0YW5zaS1vcGVyYXRvci1zb3RrIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZXJlbmNhbmFhbjp1c3VsLXJpbmNpYW4tZm9ybWFzaSIsInJvbGU6ZGlzcGFrYXRpOmluc3RhbnNpOm9wZXJhdG9yIiwicm9sZTpzaWFzbi1pbnN0YW5zaTpwZW5nYWRhYW46b3BlcmF0b3IiLCJyb2xlOnNpYXNuLWluc3RhbnNpOmJhdGFsbmlwOmFwcHJvdmFsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTphZG1pbi10ZW1wbGF0ZSIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktb3BlcmF0b3Itc3RhbmRhci1rb21wLWphYiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktcGVuZXRhcGFuLXNvdGsiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnBlcmVtYWphYW46cGFyYWYiLCJyb2xlOnNpYXNuLWluc3RhbnNpOnByb2ZpbGFzbjp2aWV3cHJvZmlsIiwicm9sZTpzaWFzbi1pbnN0YW5zaTphZG1pbjphZG1pbiIsInJvbGU6c2lhc24taW5zdGFuc2k6cGVyZW5jYW5hYW46aW5zdGFuc2ktdmFsaWRhdG9yLXN0YW5kYXIta29tcC1qYWIiXX0sInJlc291cmNlX2FjY2VzcyI6eyJhY2NvdW50Ijp7InJvbGVzIjpbIm1hbmFnZS1hY2NvdW50IiwibWFuYWdlLWFjY291bnQtbGlua3MiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6Im9wZW5pZCBlbWFpbCBwcm9maWxlIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJuYW1lIjoiREFOVVJJIERBTlVSSSIsInByZWZlcnJlZF91c2VybmFtZSI6IjE5ODcwNzIyMjAxOTAzMTAwNSIsImdpdmVuX25hbWUiOiJEQU5VUkkiLCJmYW1pbHlfbmFtZSI6IkRBTlVSSSIsImVtYWlsIjoiZGFudWFsYmFudGFuaUBnbWFpbC5jb20ifQ.DKSmJM12QB1Hf53eJAHbOETVfkFqN0MU4HuoBq190p5GNC8wid5SxvM-Ly35Cx6_DSNyb6qZ6KVOW3R_EGdEhkgOETOM6r_7jRUYy0I6AhajKM0Ge6OsSJV-de-rgOEQVOiGcO-h0oTT86rMXh1tpgxJm9F0IvyBrWlKhVWO-zRkPT8SIp0gt9vwIgEB84TWsdOMZt5QWTyBEUg4Cx0IFOonHKIYvfGb2s2XIF8RIDnT3HXRzUWqQ_N07abr7uPlQ8i7cT64lR1qm6lnGEQ7gP5Ndzh8KMLUwRmp9Gg2xP0pCudI1ITFTQpZqnrmEquIeuRpeE_qF9_1Md4M3RG18g';
  
        $response = $client->request('GET', 'https://api-siasn.bkn.go.id/siasn-instansi/pengadaan/usulan/monitoring?jenis_pengadaan_id=02&status_usulan=&periode='.$tahun.'&limit='.$limit.'&offset='.$offset, [
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
                'jenis_jabatan_id' => $row->usulan_data->data->jenis_jabatan_id,
                'jenis_jabatan_nama' => $row->usulan_data->data->jenis_jabatan_nama,
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
                'kpkn_id' => ($row->usulan_data->data->kpkn_id)?$row->usulan_data->data->kpkn_id:0,
                'kpkn_nama' => $row->usulan_data->data->kpkn_nama,
                'lokasi_id' => $row->usulan_data->data->lokasi_id,
                'lokasi_nama' => $row->usulan_data->data->lokasi_nama,
                'masa_kerja_bulan' => $row->usulan_data->data->masa_kerja_bulan,
                'masa_kerja_tahun' => $row->usulan_data->data->masa_kerja_tahun,
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
                'tahun_gaji' => $row->usulan_data->data->tahun_gaji,
                'tahun_lulus' => $row->usulan_data->data->tahun_lulus,
                'tempat_lahir' => $row->usulan_data->data->tempat_lahir,
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

            $model->upsert($param);
        }
    }
    
}
