<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login', [
            'title' => "Admin Login",
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|min:8',
        ]);

        if(Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin/program');
        }


        return back()->with('login_error', 'Gagal Login');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        if(!Auth::guard('web')->check()){
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } 
        return back();
    }
}
