<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()){
            $user = Auth::user();
            // User is logged in, redirect to dashboard
            return redirect('/dashboard');
        } else {
            // User is not logged in, show login form
            return view('simple/login');
        }
    }

    public function login(Request $request)
    {
        $email = $request->input('email', false);
        $password = $request->input('password', false);

        // Attempt to log the user in and check for failure at the same time
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            // Login failed, show error message
            $request->session()->flash('login_status', 'Incorrect Username/Password!');
        }

        return redirect('/');
    }

    public function dashboard()
    {
        if (Auth::check()){
            $user = Auth::user();
            // User is logged in, show dashboard
            return view('simple/dashboard', compact('user'));
        } else {
            // User is not logged in, redirect to login
            return redirect('/');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
