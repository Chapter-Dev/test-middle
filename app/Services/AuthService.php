<?php
namespace App\Services;

class AuthService extends DatabaseService
{
    public $email;

    public $token;

    public $uuid;

    /**
     * Login request 
     * 
     * @param array $request
     * 
     * @author Apoorv Vyas
     */
    function login(){
        $this->request_url = $this->base_url.'user/login';
        $query = [
            'email' => $this->email
        ];
        if($this->token){
            $this->request_url = $this->base_url.'user/login/'.$this->token;
            $query = [];
        }
        $this->get($query);
    }

    function verify(){

        if(!empty($this->uuid) && !empty($this->token)){
            $this->request_url = $this->base_url.'/verify-user';

            $this->post([
                'uuid' => $this->uuid,
                'token' => $this->token
            ]);
        }
        
    }
}