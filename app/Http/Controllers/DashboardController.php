<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function GetDashboard()
    {
        return view('auth.dashboard');
    }
    public function IsAuth(Request $request)
    {
        $credentials = $request->only('admin_email', 'admin_password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'admin_email' => 'Invalid credentials',
        ]);
    }
    public function Logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
