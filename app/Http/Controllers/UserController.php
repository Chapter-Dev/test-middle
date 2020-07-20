<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;

class UserController extends Controller
{
    protected $authService;
    protected $userService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        AuthService $auth, UserService $user
    )
    {
        $this->authService = $auth;
        $this->userService = $user;
    }

    function login(Request $request){
        
    }

    function loginSubmit($token){
        
    }

    function register(Request $request){

    }

    function profile(){

    }

    function update(Request $request){

    }
}