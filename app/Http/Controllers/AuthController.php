<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        $emailOrName = $request->input('email');
        $password = $request->input('password');

        $isEmail = filter_var($emailOrName, FILTER_VALIDATE_EMAIL);
        $credentials = $isEmail ? ['email' => $emailOrName] : ['name' => $emailOrName];
        $credentials['password'] = $password;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_active == '1') {
                // Update last login
                User::where('email', $user->email)->update([
                    'last_login' => now(),
                    'login_counter' => $user->login_counter + 1,
                ]);

                // Redirect to the intended route after login
                return redirect()->intended('/home');
            } else {
                return redirect('/')->with('statusLogin', 'Give Access First to User');
            }
        } else {
            return redirect('/')->with('statusLogin', 'Wrong Email/Name or Password');
        }
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('statusLogout','Success Logout');
    }
}
