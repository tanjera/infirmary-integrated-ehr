<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $req) {
        $users = User::all();
        return view('users.index')->with("users", $users);
    }
    public function create(Request $req){
        return view('users.create');
    }
    public function add(Request $req){
        $validated = $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
            'role' => $req->role
        ]);

        return redirect('/users')->with('message', '"' . $req->email .'" saved successfully!');
    }
    public function edit(Request $req){
        $user = User::find($req->id);
        return view('users.edit')->with("user", $user);
    }
    public function update(Request $req){
        $user = User::find($req->id);

        if (is_null($req->role)) {
            $req->request->add(['role' => $user->role]);
        }

        $validated = $req->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user->update([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
            'role' => $req->role,
        ]);
        return redirect('/users')->with('message', '"' . $user->name .'" saved successfully!');
    }
    public function confirm(Request $req){
        $user = User::find($req->id);
        return view('users.confirm')->with("user", $user);
    }
    public function delete(Request $req){
        // Never delete a user... may break old associations (e.g. in charting)
        // Replace email (unique) w/ uuid to open email for future registrations
        $user = User::find($req->id);
        $user->update([
            'active' => false,
            'email' => $user->id
        ]);

        return redirect('/users')->with('message', '"' . $user->name .'" deleted successfully!');
    }
}
