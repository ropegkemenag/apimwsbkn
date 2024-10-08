<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Casn extends BaseController
{
    public function index()
    {
        //
    }

    public function dashboard($id=false)
    {
        // https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd=
        $client = service('curlrequest');

        $token = "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJBUWNPM0V3MVBmQV9MQ0FtY2J6YnRLUEhtcWhLS1dRbnZ1VDl0RUs3akc4In0.eyJleHAiOjE3Mjg0MzAxNjAsImlhdCI6MTcyODM4Njk2MCwiYXV0aF90aW1lIjoxNzI4Mzg2OTYwLCJqdGkiOiIwNzQxZjdlZS0xZGI3LTRkMTAtYWQ4MS03Zjg5ZWUwMGRjYzciLCJpc3MiOiJodHRwczovL3Nzby1zaWFzbi5ia24uZ28uaWQvYXV0aC9yZWFsbXMvcHVibGljLXNpYXNuIiwiYXVkIjoiYWNjb3VudCIsInN1YiI6IjdjYmQyYTJkLTlhNDAtNGQ2Zi05NWMwLWYxZWMyYmRkODc3MCIsInR5cCI6IkJlYXJlciIsImF6cCI6ImRhc2hib2FyZC1zc2Nhc24iLCJzZXNzaW9uX3N0YXRlIjoiYmMyMDY1NTYtMTBiZC00OGQ4LTgyNjQtMjYzZjI3MzZiYTE5IiwiYWNyIjoiMSIsImFsbG93ZWQtb3JpZ2lucyI6WyJodHRwOi8vZGFzaGJvYXJkLXNzY2Fzbi5ia24uZ28uaWQiLCJodHRwczovL3RyYWluaW5nLWRhc2hib2FyZC1zc2Nhc24uYmtuLmdvLmlkIiwiaHR0cDovL2xvY2FsaG9zdDozMDAwIiwiaHR0cHM6Ly9kYXNoYm9hcmQtc3NjYXNuLmJrbi5nby5pZCJdLCJyZWFsbV9hY2Nlc3MiOnsicm9sZXMiOlsib2ZmbGluZV9hY2Nlc3MiLCJ1bWFfYXV0aG9yaXphdGlvbiJdfSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJtYW5hZ2UtYWNjb3VudC1saW5rcyIsInZpZXctcHJvZmlsZSJdfX0sInNjb3BlIjoib3BlbmlkIGVtYWlsIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJBSE1BRCBaQUtZIiwicHJlZmVycmVkX3VzZXJuYW1lIjoiMTk4NzAzMTUyMDI0MjExMDEwIiwiZ2l2ZW5fbmFtZSI6IkFITUFEIiwiZmFtaWx5X25hbWUiOiJaQUtZIiwiZW1haWwiOiJhaG1hZDdha3lAZ21haWwuY29tIn0.DSvuy5MJJGVWLoTzjHGeLz75VlD3W0_FVFDeaPjeIR_uG-QloewDq9ZulA4Lfzaux4BIxEeBj-9DHNVrYMbgl7CIJDATS6tIzTQxck1Zv0SIoKDbJUJmdwrffHSUScbSpSj2CwJ7Nn7nnPgrrOmLgwDgHwwgSDw47JeiEXr_u_mVQu52lG4ePk-ZhI7s_CAKM0LAWklRsWab7WO1At1co_4ZWH3_C4trG6meGcNi7U_W4gtV7DTPeUz6Qj50rzGjbUqyLojGifiW7XbaT0dityBFWfSjAwlQY6W1dyNGFq4lbAQEUXy79SIfRL825QkLbjD4gb5J15He7lTW3B0RxA";
        $response = $client->request('GET', 'https://api-sscasn.bkn.go.id/2024/dashboard/cpns/statistik?pengadaan_kd='.$id, [
            'headers' => [
                'Accept'        => 'application/json',
                'Content-Type' => 'application/json',
                'Origin' => 'https://dashboard-sscasn.bkn.go.id',
                'referer' => 'https://dashboard-sscasn.bkn.go.id/',
                'Authorization'     => 'Bearer '.$token,
            ],
            'debug' => true,
            'verify' => false
        ]);

        return $response->getBody();
    }
}
