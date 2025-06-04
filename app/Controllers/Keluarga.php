<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Keluarga extends BaseController
{
    public function pasangan()
    {
        $data = [
            'agamaId' => $this->request->getVar('agamaId'),
            'alamat' => $this->request->getVar('alamat'),
            'email' => $this->request->getVar('email'),
            'id' => $this->request->getVar('id'),
            'jenisIdentitas' => $this->request->getVar('jenisIdentitas'),
            'nama' => $this->request->getVar('nama'),
            'noAktaCerai' => $this->request->getVar('noAktaCerai'),
            'noAktaMenikah' => $this->request->getVar('noAktaMenikah'),
            'noAktaMeninggal' => $this->request->getVar('noAktaMeninggal'),
            'noHp' => $this->request->getVar('noHp'),
            'nomorIdentitas' => $this->request->getVar('nomorIdentitas'),
            'pasanganKe' => $this->request->getVar('pasanganKe'),
            'pnsOrangId' => $this->request->getVar('pnsOrangId'),
            'statusHidup' => $this->request->getVar('statusHidup'),
            'statusPekerjaanPasangan' => $this->request->getVar('statusPekerjaanPasangan'),
            'statusPernikahan' => $this->request->getVar('statusPernikahan'),
            'tglAktaMenikah' => $this->request->getVar('tglAktaMenikah'),
            'tglLahir' => $this->request->getVar('tglLahir'),
        ];
        $client = service('curlrequest');
        $response = $client->request('POST', getenv('wso.apisiasn.endpoint').'/keluarga/pasangan/save', [
            'headers' => [
                'Auth'          => 'bearer '.getenv('wso.auth.token'),
                'Authorization' => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'json' => $data,
            'verify' => false
        ]);

        return $this->response->setJSON($response->getBody());
    }

    function anak() {

        $data = [
            'agamaId' => $this->request->getVar('agamaId'),
            'aktaKelahiran' => $this->request->getVar('aktaKelahiran'),
            'aktaMeninggal' => $this->request->getVar('aktaMeninggal'),
            'alamat' => $this->request->getVar('alamat'),
            'email' => $this->request->getVar('email'),
            'id' => $this->request->getVar('id'),
            'isPns' => $this->request->getVar('isPns'),
            'jenisAnakId' => $this->request->getVar('jenisAnakId'),
            'jenisIdDokumenId' => $this->request->getVar('jenisIdDokumenId'),
            'jenisKawinId' => $this->request->getVar('jenisKawinId'),
            'jenisKelamin' => $this->request->getVar('jenisKelamin'),
            'nama' => $this->request->getVar('nama'),
            'nipAnak' => $this->request->getVar('nipAnak'),
            'nomorHp' => $this->request->getVar('nomorHp'),
            'nomorIdDocument' => $this->request->getVar('nomorIdDocument'),
            'nomorTelpon' => $this->request->getVar('nomorTelpon'),
            'pasanganId' => $this->request->getVar('pasanganId'),
            'pnsOrangId' => $this->request->getVar('pnsOrangId'),
            'statusHidup' => $this->request->getVar('statusHidup'),
            'tglLahir' => $this->request->getVar('tglLahir'),
            'tglMeninggal' => $this->request->getVar('tglMeninggal')
        ];
        $client = service('curlrequest');
        $response = $client->request('POST', getenv('wso.apisiasn.endpoint').'/keluarga/anak/save', [
            'headers' => [
                'Auth'          => 'bearer '.getenv('wso.auth.token'),
                'Authorization' => 'Bearer '.service('cache')->get('oauth2.token'),
            ],
            'json' =>
            $data,
            'verify' => false
        ]);
        return $this->response->setJSON($response->getBody());    
    }
}
