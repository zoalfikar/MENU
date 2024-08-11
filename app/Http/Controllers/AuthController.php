<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $data = $req->only('identifier','password');
        $credentials  = Validator::make($data,[
            'identifier' => 'required|numeric|min:1',
            'password' => 'required|string|min:8',
        ])->validate();
        if (!Auth::attempt($credentials)) {
            return  redirect()->back()->withInput($req->only(['identifier']))->withErrors(['error'=>'identifier or password is incorrect']);
        }
        $req->session()->regenerate();
        if (Auth::user()->role === 'admin')
            return redirect('/admin/dashboard');
        return redirect('/menu');

    }
    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->flush();
        return redirect('/');

    }
}
