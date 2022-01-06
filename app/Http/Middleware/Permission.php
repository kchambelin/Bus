<?php

namespace App\Http\Middleware;

use App\Models\Users;
use App\Models\Operation;
use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $page
     * @return mixed
     */
    public function handle($request, Closure $next, $operationName)
    {

        if(Auth::check()) {

            $id_user = Auth::user()->iduser;
            $grade = Auth::user()->grade;

            try {
                $operation = Operation::where('name', $operationName)->first();
                $operationAttributes = $operation->getAttributes();

                if(isset($operationAttributes['route'])) {

                    $rankPermission = \App\Models\Permission::where('grade', $grade)
                        ->where('operations_idoperation', $operation->idoperation)
                        ->get();

                    if($rankPermission->count() < 1) {
                        return redirect('home');
                    }
                    else
                        return $next($request);

                }

            }
            catch (\Exception $exception) {
                // Opération on trouvée
                dd($exception);
            }

            return $next($request);

        }
        else return redirect('login');

    }

    public static function hasUserOperation($iduser, $operationName)
    {

        $userRankID = Users::where("iduser", $iduser)->first()->grade;

        $operation = Operation::where('name', $operationName)->first();
        if(!$operation)
            return false;

        $permission = \App\Models\Permission::where('grade', $userRankID)->where('operations_idoperation', $operation->idoperation)->first();
        if(!$permission)
            return false;

        return true;

    }

    public static function hasOperation($operationName)
    {

        if(Auth::check()) {

            $user = Auth::user();
            return self::hasUserOperation($user->iduser, $operationName);

        }
        else return false;

    }

}
