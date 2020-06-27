<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Members\MemberRequest;
use App\Models\Zip2Address;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class Zip2AddressController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        \Log::info($request);
        $zipcode = $request['zipcode'] ;

        $client = new Client();

        $url = 'http://zipcloud.ibsnet.co.jp/api/search?zipcode=' . $zipcode;
        $res = $client->request('GET', $url);
        \Log::info($res->getStatusCode());
        // "200"
        \Log::info($res->getHeader('content-type'));
        // 'application/json; charset=utf8'
        \Log::info($res->getBody());
        return $res->getBody();
    }
}
