<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        //
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
            'verify' => false
        ]);

        echo $response->getBody();
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

        echo $response->getBody();
    }
}
