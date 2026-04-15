<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function index()
    {
        $users = User::query()
            ->select('id', 'name', 'email', 'created_at')
            ->latest('created_at')
            ->take(20)
            ->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'User created successfully.');
    }

    public function manage()
    {
        $users = User::query()
            ->select('id', 'name', 'email', 'created_at')
            ->latest('created_at')
            ->get();

        return view('users.manage', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::query()->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        if (!empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $user->update($payload);

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function GetUserUpdate($id)
    {
        $user = User::find($id);
        return view('auth.updateUser', compact('user'));
    }

    public function AddUser(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user) {
            Admin::create([
                'user_id' => $user->id,
                'role' => 'admin',
            ]);

            return view('auth.dashboard');
        }

        return back()->with('error', 'the process has failed!');
    }
    public function UpdateUser(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return redirect()->route('get.users');
        }

        return back();
    }
    public function DeleteUser($id)
    {

        if (User::findOrFail($id)->delete()) {
            return redirect()->route('get.users');
        }

        return back();
    }

    public function FindUser($id)
    {
        return User::find($id);
    }

    public function FindUserWithName($name)
    {
        return User::where('name', $name)->get();
    }

}
