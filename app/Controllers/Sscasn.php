<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Sscasn extends BaseController
{
    public function index()
    {
        return view('usersscasn');
    }

    function saveuser() {
        $client = service('curlrequest');

        $form = $this->request->getVar();

        $response = $client->request('POST', 'https://admin-sscasn.bkn.go.id/userKewenangan/save', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Origin' => null,
                'referer' => 'https://perencanaan-siasn.bkn.go.id/pengelolaan/verval-perbaikan-update-rincian-formasi-menpan/d9f13001-ad65-412e-a129-d744b40acba8/3a6b38a7-ec6c-4faf-ad0c-7498208d72fb',
                'Cookie'     => '_ga=GA1.1.1409040940.1726985318; _ga_5GQ07M1DL1=GS1.1.1729584198.3.1.1729584220.0.0.0; _ga_NVRKS9CPBG=GS1.1.1729597976.14.0.1729597976.0.0.0; BIGipServerpool_prod_sscasn2024_kube=3154600970.47873.0000; 9760101acce488cfa3a2041bbb8bb77f=ac978f6657646bddd4c30510616f0898; JSESSIONID=F28FD2729C90254E28925E25B4B08AE5; OAuth_Token_Request_State=d3ce544e-a30e-41cd-a112-85eb7c0c7e97; _ga_THXT2YWNHR=GS1.1.1729998749.12.0.1729998750.0.0.0',
            ],
            'form_params' => $form,
            'debug' => true,
            'verify' => false
        ]);

        $response = json_decode($response->getBody());

        return $this->response->setJSON($response);
    }
}
