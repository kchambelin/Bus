<?php

namespace App\Http\Middleware;

use App\Models\UserDetails;
use App\Models\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOption\None;

class AuthUser
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
        return $next($request);
    }

    public static function getDetail($attr)
    {

        if(Auth::check()) {

            $iduser = Auth::user()->iduser;

            try {

                return UserDetails::where('users_iduser', $iduser)->first()->$attr;

            } catch (\Exception $exception) {

                dd($exception);
            }

        }
        else return redirect('login');

    }

}
