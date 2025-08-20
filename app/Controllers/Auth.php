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
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Cookie' => 'AUTH_SESSION_ID=dbb9f0bc-17d7-447e-9533-7eaec933f50a.node1; AUTH_SESSION_ID_LEGACY=dbb9f0bc-17d7-447e-9533-7eaec933f50a.node1; KEYCLOAK_SESSION=public-siasn/af241811-1ae5-4759-970e-4e22690b3397/dbb9f0bc-17d7-447e-9533-7eaec933f50a; KEYCLOAK_SESSION_LEGACY=public-siasn/af241811-1ae5-4759-970e-4e22690b3397/dbb9f0bc-17d7-447e-9533-7eaec933f50a; KEYCLOAK_IDENTITY=eyJhbGciOiJIUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICIyMDA0ZDBmMy1mNjI5LTRjYTQtYWZiMC1kNGRkYzhlMTU2ZjUifQ.eyJleHAiOjE3NTU2OTk1NDgsImlhdCI6MTc1NTY1NjM0OCwianRpIjoiYjdjZWFiZDQtZWU4ZC00ODViLThhNjktOWU2ZGNiMjQwNjI4IiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsInN1YiI6ImFmMjQxODExLTFhZTUtNDc1OS05NzBlLTRlMjI2OTBiMzM5NyIsInR5cCI6IlNlcmlhbGl6ZWQtSUQiLCJzZXNzaW9uX3N0YXRlIjoiZGJiOWYwYmMtMTdkNy00NDdlLTk1MzMtN2VhZWM5MzNmNTBhIiwic3RhdGVfY2hlY2tlciI6InhnSXpoallReFNGZTZhWlVwRGszQUhjOWc2LWFCVVJxc09iakZVeFdsQU0ifQ.jncL_u3vRaO7s06455Z4TobihBUD6jttT3AfNGa9Cls; KEYCLOAK_IDENTITY_LEGACY=eyJhbGciOiJIUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICIyMDA0ZDBmMy1mNjI5LTRjYTQtYWZiMC1kNGRkYzhlMTU2ZjUifQ.eyJleHAiOjE3NTU2OTk1NDgsImlhdCI6MTc1NTY1NjM0OCwianRpIjoiYjdjZWFiZDQtZWU4ZC00ODViLThhNjktOWU2ZGNiMjQwNjI4IiwiaXNzIjoiaHR0cHM6Ly9zc28tc2lhc24uYmtuLmdvLmlkL2F1dGgvcmVhbG1zL3B1YmxpYy1zaWFzbiIsInN1YiI6ImFmMjQxODExLTFhZTUtNDc1OS05NzBlLTRlMjI2OTBiMzM5NyIsInR5cCI6IlNlcmlhbGl6ZWQtSUQiLCJzZXNzaW9uX3N0YXRlIjoiZGJiOWYwYmMtMTdkNy00NDdlLTk1MzMtN2VhZWM5MzNmNTBhIiwic3RhdGVfY2hlY2tlciI6InhnSXpoallReFNGZTZhWlVwRGszQUhjOWc2LWFCVVJxc09iakZVeFdsQU0ifQ.jncL_u3vRaO7s06455Z4TobihBUD6jttT3AfNGa9Cls; _ga_NVRKS9CPBG=GS1.1.1737046729.23.1.1737046734.0.0.0; _ga_6L51PKND1M=GS1.1.1738813705.5.0.1738813705.0.0.0; _ga=GA1.1.1409040940.1726985318; _ga_DRZFS4E65W=GS2.1.s1746360884$o4$g1$t1746363331$j0$l0$h0; _ga_0814XD8D5J=GS2.1.s1746363331$o5$g0$t1746363331$j0$l0$h0; _ga_LM1J7YFLJ2=GS2.1.s1746363331$o3$g0$t1746363331$j0$l0$h0; _ga_35R96W5J1R=GS2.1.s1747740545$o1$g0$t1747740545$j0$l0$h0; _ga_P60EQWGT4B=GS2.1.s1747987355$o11$g1$t1747987416$j60$l0$h0$dTegQPUTb6s3BJF769R4mQ-yVaLE1tCxmuA; _ga_SXQ0KJ7TRT=GS2.1.s1753243952$o5$g0$t1753243952$j60$l0$h0; _ga_5GQ07M1DL1=GS2.1.s1753674916$o13$g1$t1753674982$j58$l0$h0; _ga_THXT2YWNHR=GS2.1.s1754381295$o93$g1$t1754381618$j60$l0$h0; _ga_XSYPSH7VH8=GS2.1.s1755522993$o8$g1$t1755523125$j8$l0$h0; BIGipServerpool_keycloak_siasn=2953339914.36895.0000; _ga_D3VMVHCY1Y=GS2.1.s1755655592$o6$g1$t1755655617$j35$l0$h0'
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
