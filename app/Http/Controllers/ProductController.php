<?php

namespace App\Http\Controllers;

use App\Models\User;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $client = ClientBuilder::create()
            ->setHosts(['http://172.18.0.2:9200'])
            ->build();
        $params = [
            'index' => 'products',
            'body' => [
                'query' => [

                    'wildcard' => [
                        'name' => '*oduct*'
                    ]
                ]
            ]

        ];

        return $response = $client->search($params);
    }

    public function createIndex()
    {
        $success = User::createIndex();

        if ($success) {
            dd($success);
            /*return redirect()->route('products.index')
                ->with('success', 'Elasticsearch index created successfully!');*/
        } else {
            return 'failed';
            /*return redirect()->route('products.index')
                ->with('error', 'Failed to create Elasticsearch index');*/
        }
    }

    public function createFirstIndex()
    {

    }
}
