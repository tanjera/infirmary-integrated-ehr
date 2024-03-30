<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $req) {
        $users = User::all();
        return view('users.index')->with("users", $users);
    }
    public function edit(Request $req){
        $user = User::find($req->id);
        return view('users.edit')->with("user", $user);
    }
    public function update(Request $req){
        $user = user::find($req->id);
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
        $user = User::find($req->id);
        $user->delete();

        return redirect('/users')->with('message', '"' . $user->name .'" deleted successfully!');
    }
}
