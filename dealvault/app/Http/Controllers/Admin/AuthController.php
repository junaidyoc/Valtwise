<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $password = env('ADMIN_PASSWORD', 'valtwise@admin123');

        if ($request->password === $password) {
            $request->session()->put('admin_authenticated', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Wrong password!']);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        return redirect()->route('admin.login');
    }
}
