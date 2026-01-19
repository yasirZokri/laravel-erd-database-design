<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function AdminLogin(LoginRequest $request)
    {
        $admin = Admin::where('admin_email', $request->admin_email)
            ->where('isActive', 1)
            ->first();

        if (!$admin || !Hash::check($request->admin_password, $admin->admin_password)) {
            return back()->withErrors([
                'admin_email' => 'Invalid credentials',
            ]);


        }

        Auth::guard('admin')->login($admin);

        // ⭐ مهم جدًا
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function GetLogin()
    {
        return view('auth.login');
    }

    public function GetRegisteration()
    {
        return redirect('login');
    }

    public function GetAllAdmins()
    {
        $admins = Admin::all();

        if($admins != null)
        {
            return view('auth.editAdmins', compact('admins'));
        }
        return back()->with('erorr', 'the Admins is not available');
    }

    public function GetEditAdmins()
    {
        return view('auth.editAdmins');
    }


}
