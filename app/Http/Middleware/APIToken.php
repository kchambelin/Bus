<?php

namespace App\Http\Middleware;

use App\Models\UserToken;
use Closure;
use Illuminate\Http\Request;

class APIToken
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
        if(self::isTokenCorrect($request->header('token'))) {
            return $next($request);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Invalid token",
            ]);
        }
    }

    public static function isTokenCorrect($token)
    {

        $t = UserToken::where('token', $token)->first();

        return $t;
    }

    // public static function hasTokenOperation($token, $operationName)
    // {
    //     $t = self::isTokenCorrect($token);
    //     if(!$t)
    //         return false;
    //     return Permission::hasUserOperation($t->users->id, $operationName);
    // }

    public static function getUserByToken($token)
    {

        $t = UserToken::where('token', $token)->first();

        return $t->login;
    }

}
