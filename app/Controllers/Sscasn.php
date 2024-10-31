<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersscasnModel;

class Sscasn extends BaseController
{
    public function index()
    {
        return view('usersscasn');
    }

    function getunor($id) {
        $model = new UsersscasnModel;

        $data = $model->where('userid',$id)->orWhere('userid2',$id)->findAll();

        return $this->response->setJSON($data);
    }

    function getuser() {
        $model = new UsersscasnModel;

        $data = $model->where('added',0)->findAll(100,0);

        foreach ($data as $row) {
            $add = $this->saveuser($row->userid,$row->jenisPengadaan,$row->profile);

            $update = $model->update($row->id,['added' => 1]);
        }
        // return $this->response->setJSON($data);
    }

    function saveuser($userid,$jenis,$profile) {
        $client = service('curlrequest');

        // $form = $this->request->getVar();

        $response = $client->request('POST', 'https://admin-sscasn.bkn.go.id/userKewenangan/save', [
            'headers' => [
                'Origin' => null,
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Cookie'     => '_ga=GA1.1.1409040940.1726985318; _ga_5GQ07M1DL1=GS1.1.1729584198.3.1.1729584220.0.0.0; _ga_NVRKS9CPBG=GS1.1.1729597976.14.0.1729597976.0.0.0; BIGipServerpool_prod_sscasn2024_kube=3154600970.47873.0000; 9760101acce488cfa3a2041bbb8bb77f=ac978f6657646bddd4c30510616f0898; JSESSIONID=58DFA0AA1F244DBD78450618BF158E12; OAuth_Token_Request_State=7b1d214e-89ab-4e1c-9245-c9e7618d642b; _ga_THXT2YWNHR=GS1.1.1730096260.14.0.1730096262.0.0.0',
            ],
            'form_params' => [
                'userId' => $userid,
                'jenisPengadaan' => $jenis,
                'profile' => $profile,
            ],
            'debug' => true,
            'verify' => false
        ]);

        $response = json_decode($response->getBody());

        return $this->response->setJSON($response);
    }
}
