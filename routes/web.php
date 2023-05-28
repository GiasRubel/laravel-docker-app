<?php


use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'Welcome';

    $client = ClientBuilder::create()
        ->setHosts(['http://172.18.0.2:9200'])
        ->build(); //dd($client);
    $response = $client->info();

    echo $response['version']['number'];

    //dd( $response['version']['number']);

    $params = [
        'index' => 'my_index',
        'body' => [
            'settings' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
            ],
            'mappings' => [
                'properties' => [
                    'title' => [
                        'type' => 'text',
                    ],
                    'description' => [
                        'type' => 'text',
                    ],
                ],
            ],
        ],
    ];

    $response = $client->indices()->create($params);

    return $response;
});
Route::get('/get-user', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/create-index-user', 'App\Http\Controllers\ProductController@createIndex')->name('products.index.create');
Route::get('/create-first-index', 'App\Http\Controllers\ProductController@createFirstIndex')->name('products.first.create');

//Route::get('/elastic', 'MyController@indexDocument');
