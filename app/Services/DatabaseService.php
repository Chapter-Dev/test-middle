<?php
namespace App\Services;

use GuzzleHttp\Client;

class DatabaseService
{
    protected $client;

    private $base_url = null;

    protected $request_url = null;

    protected $response = null;
    
    
    function __construct(Client $client){
        $this->client = $client;
        $this->base_url = env('DATABASE_URL');
    }

    function get($params = []){

        $this->response = $this->client->get($this->request_url,$params);
    }

    function post($params){
        $this->response = $this->client->get($this->request_url,$params);
    }

    function response(){
        return $this->response->getBody();
    }

    function status(){
        return $this->response->getStatusCode();
    }
}