<?php

namespace App\Http\Controllers;

use Exception;
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
        try{
            $this->authService->email = $request->email;
            $this->authService->login();
            $response = $this->authService->response();
            return response()->json($response,$this->authService->status());
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ],
            $this->authService->status());
        }
    }

    function loginSubmit($token){
        try{
            $this->authService->token = $token;
            $this->authService->login();

            return response()->json(
                $this->authService->response(),
                $this->authService->status()
            );
        }
        catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
            ],
            $this->authService->status());
        }
    }

    function register(Request $request){
        try{
            $this->userService
            ->put(collect($request->all()))
            ->create();

            return response()->json(
                $this->authService->response(),
                $this->authService->status()
            );
        }
        catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
            ],
            $this->userService->status());
        }

    }

    function profile(Request $request){
        $this->userService->details($request->uuid);
        $user = $this->userService->response()->user;

        try{
            return response()->json(
                $this->userService->response(),
                $this->userService->status()
            );
        }
        catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
            ],
            $this->userService->status());
        }

    }

    function update(Request $request,$uuid){
        $this->userService
            ->put(collect($request->all()))
            ->update($uuid);

        try{
            return response()->json(
                $this->userService->response(),
                $this->userService->status()
            );
        }
        catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
            ],
            $this->userService->status());
        }
    
    }
}