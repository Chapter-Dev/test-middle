<?php
namespace App\Services;

use Exception;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\TooManyRedirectsException;

class DatabaseService
{
    protected $client;

    protected $base_url = null;

    protected $request_url = null;

    protected $response = null;

    protected $status_code = 200;
    
    
    function __construct(Client $client){
        $this->client = $client;
        $this->base_url = env('DATABASE_URL');
    }

    function get($params = []){
        $params = [
            'query' => http_build_query($params)
        ];
        
        try{
            $this->response = $this->client->get($this->request_url,$params,[
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept'     => 'application/json',
                    'X-Foo'      => ['Bar', 'Baz']
                ]
            ]);
            $this->status_code = $this->response->getStatusCode();
        }
        catch(RequestException $e){
            $this->throwException($e);
        }
        catch(ServerException $e){
            $this->throwException($e);
        }
        catch(ClientException $e){
            $this->throwException($e);
        }
        catch(Exception $e){
            $this->throwException($e);
        }
    }

    function post($params){
        $params = [
            'json' => $params
        ];
        try{
            $this->response = $this->client->post($this->request_url,$params);
            $this->status_code = $this->response->getStatusCode();
        }
        catch(RequestException $e){
            $this->throwException($e);
        }
        catch(ServerException $e){
            $this->throwException($e);
        }
        catch(ClientException $e){
            $this->throwException($e);
        }
        catch(Exception $e){
            $this->throwException($e);
        }
        
    }

    function response(){
        return json_decode($this->response->getBody()->getContents());
    }

    function status(){
        return $this->status_code;
    }

    function throwException($e){
        $this->status_code = $e->getCode();
        $this->response = $e->getResponse();
        throw new Exception($this->response()->message);
    }
}