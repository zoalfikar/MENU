<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function redirect() {
        if (!Auth::check()) return redirect('/show-login');
        if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
        if (Auth::user()->role === 'user') return redirect('/menu');
    }

    public function getUser()
    {
        return response()->json(['user'=> Auth::user()]);
    }
}
