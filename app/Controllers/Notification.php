<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Notifikasi;

class Notification extends BaseController
{
    public function index()
    {
        //
    }

    public function reportpppk() {
        $pppk = json_decode($this->dashboardpppk());

        $text = '📑 *Info*

Yth. *Kepala Bagian Pengadaan dan Mutasi ASN*

Berikut Kami informasikan laporan statistik pelamar PPPK Teknis SSCASN 2024

Jumlah Pendaftar  : *'.$pppk->data->jml_pendaftar.'*
Jumlah Submit  : *'.$pppk->data->jml_submit.'*
Jumlah MS  : *'.$pppk->data->jml_ms.'*
Jumlah TMS  : *'.$pppk->data->jml_tms.'*
Jumlah Belum Verif  : *'.$pppk->data->jml_blm_verif.'*


Updated at: '.$pppk->data->updated_at.'
---------------------------------------------

*_Pesan ini disampaikan secara otomatis_*

*Biro Sumber Daya Manusia*' ;

                $hp   = '6285219898201';
                $hp2   = '6281280706565';

                $notif = new Notifikasi();
                $notif->sendWhatsapp($hp,$text);
                $notif->sendWhatsapp($hp2,$text);
    }

    public function dashboardpppk()
    {
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

        return $response->getBody();
    }
}
