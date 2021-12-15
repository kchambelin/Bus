<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Users as Users;
use App\Models\UserDetails as UserDetails;
use App\Models\UserToken as UserToken;

class CreateUserController extends Controller
{
    function Create(Request $request)
    {

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $password = $request->input('password');

        if(!ctype_alnum($password)) return [
            "error" => "Password not alphanumerical",
            "err_message" => "Error: password should countain A-Z, a-z, 0-9 characters only."
        ];

        $login = Users::where('email', $email)->first();

        if ($login) {
            return [
                "error" => "Already exists",
                "err_message" => "Error: this user already exists."
            ];
        }

        {
            $lastIdUser = Users::orderBy('iduser', 'desc')->first()->iduser;

            $user = new Users;
            $user->iduser = $lastIdUser + 1;
            $user->email = $email;
            $user->grade = 0;
            $user->password = Hash::make($password);
            $user->save();
            $user->refresh();

            $lastIdDetails = UserDetails::orderBy('iduser_detail', 'desc')->first()->iduser_detail;

            $userdet = new UserDetails;
            $userdet->iduser_detail = $lastIdDetails + 1;
            $userdet->users_iduser = $lastIdUser + 1;
            $userdet->firstname = $first_name;
            $userdet->lastname = $last_name;
            $userdet->save();
            $userdet->refresh();

            $lastIdToken = UserToken::orderBy('idtoken', 'desc')->first()->idtoken;

            $token = $this->gen_uuid();

            $userToken = new UserToken;
            $userToken->idtoken = $lastIdToken + 1;
            $userToken->users_iduser = $lastIdUser + 1;
            $userToken->token = $token;
            $userToken->save();
            $userToken->refresh();

        }

    }

    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

}
