<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $req) {
        $users = User::all();
        return  view('users.index')->with("users", $users);

    }
}
