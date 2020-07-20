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
        if($this->email){
            
        }   
        elseif($this->token){

        }
    }
}