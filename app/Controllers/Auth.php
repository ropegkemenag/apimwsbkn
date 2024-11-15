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

    public function getAuth()
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

    public function getAuthorization()
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
        $auth = $cache->get('auth.token');
        $oauth2 = $cache->get('oauth2.token');

        $data = [
            'auth' => $auth,
            'oauth2' => $oauth2
        ];

        return $this->response->setJSON($data);
    }
}
