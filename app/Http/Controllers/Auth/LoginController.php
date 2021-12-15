<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function checklogin(Request $request)
    {
        $this->validate($request, [
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        if(Auth::attempt($user_data))
        {
            return redirect('home');
        }
        else
        {
            return back()->with('error', 'Unknown id.');
        }

    }

    function successlogin()
    {
        return view('home');
    }

    function logout()
    {
        Auth::logout();
        return redirect('home');
    }


}
