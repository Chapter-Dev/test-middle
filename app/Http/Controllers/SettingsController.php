<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;

class SettingsController extends Controller
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

    function getInitCredentials(Request $request){
        return $request->session()->token();
    }
}
