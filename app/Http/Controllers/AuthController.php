<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; // Import Socialite facade

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function handleAzureCallback(Request $request)
{
    return Socialite::driver('azure')->redirect();
}

public function postLogin(Request $request)
{
    try {
        // Get the user details from Azure AD after successful authentication
        $azureUser = Socialite::driver('azure')->user();
        dd($azureUser); // Debugging: Dump the Azure user details
        // Handle the user details and login logic
    } catch (\Exception $e) {
        dd($e); // Debugging: Dump the exception for troubleshooting
        // Handle any exceptions or errors that may occur during the login process
    }
}



    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('statusLogout', 'Success Logout');
    }
}
