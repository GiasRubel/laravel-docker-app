<?php

namespace App\Models;

use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function createIndex()
    {

        $client = ClientBuilder::create()
            ->setHosts(['http://172.18.0.2:9200'])
            ->build();

        $params = [
            'index' => 'products'
        ];

        $response = $client->indices()->delete($params);

      //  return ($client);

        $params = [
            'index' => 'products',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'name' => ['type' => 'text'],
                        'description' => ['type' => 'text'],
                        'price' => ['type' => 'float']
                    ]
                ]
            ]
        ];

        $response = $client->indices()->create($params);

        $params = [
            'index' => 'products',
            'body' => [
                'name' => 'Product Name',
                'description' => 'Product Description',
                'price' => 9.99
            ]
        ];

        $response = $client->index($params);

        return $response;
    }
}
