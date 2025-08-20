<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth');
    }

    public function Auth()
    {
        $client = service('curlrequest');

        $response = $client->request('POST', getenv('wso.auth.url'), [
            'form_params' => [
                'client_id'     => getenv('wso.auth.clientid'),
                'grant_type'    => 'password',
                'username'      => getenv('wso.auth.username'),
                'password'      => getenv('wso.auth.password'),
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'verify' => false,
            'debug' => true
        ]);

        $response = json_decode($response->getBody());

        
        $cache = service('cache');
        $set = $cache->save('auth.token',$response->access_token,3600);
        echo '';
    }

    public function Authorization()
    {
        $client = service('curlrequest');

        $response = $client->request('POST', getenv('wso.oauth2.url'), [
            'form_params' => [
                'grant_type'    => 'client_credentials'
            ],
            'auth' => [getenv('wso.oauth2.key'), getenv('wso.oauth2.secret'), 'basic'],
            'verify' => false
        ]);

        $response = json_decode($response->getBody());

        $cache = service('cache');
        $set = $cache->save('oauth2.token',$response->access_token,3600);
        echo 'Done';
    }

    function cache() {
        $cache = service('cache');
        $auth = getenv('wso.auth.token');
        $oauth2 = $cache->get('oauth2.token');

        $data = [
            'auth' => $auth,
            'oauth2' => $oauth2
        ];

        return $this->response->setJSON($data);
    }

    function ssotoken() {
        // https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token
        $client = service('curlrequest');

        $response = $client->request('POST', 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token', [
            'form_params' => [
                'code'     => '2c007628-b9e4-4805-94a9-f53a6e7b003f.dbb9f0bc-17d7-447e-9533-7eaec933f50a.f092cc2a-38d1-4a25-a665-22eb1a7c4f20',
                'grant_type'    => 'authorization_code',
                'client_id'      => 'bkn-siasn-perencanaan',
                'redirect_uri'      => 'https://perencanaan-siasn.bkn.go.id/silent-check-sso.html',
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'verify' => false,
            'debug' => true
        ]);

        $response = json_decode($response->getBody());

        return $this->response->setJSON($response);
        // $cache = service('cache');
        // $set = $cache->save('auth.token',$response->access_token,3600);
        // echo '';
    }
}
