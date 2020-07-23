<?php

namespace App\Http\Controllers;

use Session;
use Exception;
use Postmark\PostmarkClient;
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
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        try{
            $this->authService->email = $request->email;
            $this->authService->login();
            $response = $this->authService->response();
            $requestHost = $request->headers->get('ORIGIN');
            $client = new PostmarkClient(env('POSTMARK_TOKEN'));

            $sendResult = $client->sendEmail(
                "apoorv.vyas@chapter247.com",
                $request->email,
                "Login Token verification",
                'Hii, to login click <a href="'.$requestHost.'/login/allow/'.$response->token.'">here</a>');

            
            return response()->json($response,$this->authService->status());
        }
        catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ],
            ($this->authService->status)?? '500');
        }
    }

    function loginSubmit(Request $request, $token){
        try{
            $this->authService->token = $token;
            $this->authService->login();
            $response = $this->authService->response();

            $request->session()->put('api_token', $response->api_token);
            $request->session()->put('uuid', $response->uuid);
            return response()->json(
                $response,
                $this->authService->status()
            );
        }
        catch(Exception $e){
            return response()->json([
                'message'=>$e->getMessage(),
            ],
            ($this->authService->status)?? '500');
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
            ($this->authService->status)?? '500');
        }

    }

    function profile(Request $request){
        try{
            $this->userService->details($request->uuid);
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