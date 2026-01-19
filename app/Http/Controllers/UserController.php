<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;
class UserController extends Controller
{

    public function Index()
    {
        $users = User::select('id','name','email')->get();

        return view('auth.usersEdit', compact('users'));
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
