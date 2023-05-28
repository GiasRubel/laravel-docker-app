<?php

namespace App\Http\Controllers;


use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class MyController extends Controller
{
    public function indexDocument()
    {
        dd('gg');
        $hosts = [
            [
                'host' => 'localhost',
                'port' => 9200,
                'scheme' => 'http',
            ],
        ];

        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build(); dd($client);

        $params = [
            'index' => 'my_index',
            'id' => 'my_id',
            'body' => ['my_field' => 'my_value'],
        ];

        $response = $client->index($params);

        return response()->json($response);
    }
}
