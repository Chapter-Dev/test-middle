<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserService;

class Authenticate
{
      /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $userService;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $uuid = $request->headers->get('uuid');
        $token = $request->headers->get('token');
        if (!empty($uuid) && !empty($token)) {
            try{
                $this->authService->token = $token;
                $this->authService->uuid = $uuid;
                $this->authService->verify();
            }
            catch(Exception $e){
                
                return response($e->getMessage(),($this->authService->status)?? '401');

                return response('Unauthorized',401);
            }
        }
        elseif(empty($uuid) || empty($token)){
            
        }

        return $next($request);
    }
}
