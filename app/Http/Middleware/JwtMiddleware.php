<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(["msg" => "Token Expirado"], 401);
            }
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(["msg" => "Token Inválido"], 401);
            }
            if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) { 
                return response()->json(["msg" => "Se requiere un token"], 401);
            }
        }
        return $next($request);
    }
}
