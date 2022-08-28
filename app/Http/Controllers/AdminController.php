<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin/index', ['page' => 'index']);
    }

    public function getLogin()
    {
        return view('admin/login');
    }

    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember') == 'on';

        if (Auth::attempt(['username' => $username, 'password' => $password], $remember)) {
            return redirect('admin');
        } else {
            return back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin');
    }
}
