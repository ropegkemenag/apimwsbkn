<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Hukdis extends BaseController
{
    public function index()
    {
        //
    }

    public function get($id)
    {
        // GET /hukdis/id/{idRiwayatHukdis}
    }

    public function save()
    {
        // GET /hukdis/save
        /*
            {
            "akhirHukumanTanggal": "string",
            "alasanHukumanDisiplinId": "string",
            "golonganId": "string",
            "golonganLama": "string",
            "hukdisYangDiberhentikanId": "string",
            "hukumanTanggal": "string",
            "id": "string",
            "jenisHukumanId": "string",
            "jenisTingkatHukumanId": "string",
            "kedudukanHukumId": "string",
            "keterangan": "string",
            "masaBulan": "string",
            "masaTahun": "string",
            "nomorPp": "string",
            "path": [
                {
                "dok_id": "string",
                "dok_nama": "string",
                "dok_uri": "string",
                "object": "string",
                "slug": "string"
                }
            ],
            "pnsOrangId": "string",
            "skNomor": "string",
            "skPembatalanNomor": "string",
            "skPembatalanTanggal": "string",
            "skTanggal": "string"
            }
         */
    }
}
