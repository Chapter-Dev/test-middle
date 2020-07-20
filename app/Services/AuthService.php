<?php
namespace App\Services;

class AuthService extends DatabaseService
{
    public $email;

    public $token;

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
}