<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Validation\Rule;

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

    public function index()
    {
        $admins = Admin::query()
            ->select('admin_id', 'admin_email', 'isActive', 'created_at')
            ->latest('created_at')
            ->take(20)
            ->get();

        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'admin_email' => ['required', 'string', 'email', 'max:255', 'unique:admins,admin_email'],
            'admin_password' => ['required', 'string', 'min:8'],
            'isActive' => ['nullable', 'boolean'],
        ]);

        Admin::create([
            'admin_email' => $validated['admin_email'],
            'admin_password' => Hash::make($validated['admin_password']),
            'isActive' => (bool) ($validated['isActive'] ?? false),
        ]);

        return back()->with('success', 'Admin created successfully.');
    }

    public function manage()
    {
        $admins = Admin::query()
            ->select('admin_id', 'admin_email', 'isActive', 'created_at')
            ->latest('created_at')
            ->get();

        return view('admins.manage', compact('admins'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $admin = Admin::query()->where('admin_id', $id)->firstOrFail();

        $validated = $request->validate([
            'admin_email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins', 'admin_email')->ignore($admin->admin_id, 'admin_id'),
            ],
            'admin_password' => ['nullable', 'string', 'min:8'],
            'isActive' => ['nullable', 'boolean'],
        ]);

        $payload = [
            'admin_email' => $validated['admin_email'],
            'isActive' => (bool) ($validated['isActive'] ?? false),
        ];
        if (!empty($validated['admin_password'])) {
            $payload['admin_password'] = Hash::make($validated['admin_password']);
        }

        $admin->update($payload);

        return back()->with('success', 'Admin updated successfully.');
    }

    public function destroy($id)
    {
        $admin = Admin::query()->where('admin_id', $id)->firstOrFail();
        $admin->delete();

        return back()->with('success', 'Admin deleted successfully.');
    }


}
