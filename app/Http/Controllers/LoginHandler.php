<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginHandler extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->exists('user')) return redirect('/');
        return view('login');
    }
    public function logout(Request $request)
    {
        session_start();
        unset($_SESSION['user']);
        $request->session()->forget(['user']);
        return redirect('/');
    }
    public function store(Request $request)
    {
        session_start();
        if($request->username == "admin"){
            if(password_verify($request->password, HASH::make(env("ADMIN_PASSWORD", "password")))){
                session(['user' => [
                    'username' => Hash::make("admin"),
                    'password' => Hash::make($request->password)
                ]]);
                return redirect('/');
            }
        }
        else if($request->username == "user"){
            if(password_verify($request->password, HASH::make(env("USER_PASSWORD", "password")))){
                session(['user' => [
                    'username' => Hash::make("user"),
                    'password' => Hash::make($request->password)
                ]]);
                return redirect('/');
            }
        }
        unset($_SESSION["user"]);
        return view("login", [
            'error' => 'Wrong username or password!'
        ]);
    }
}
