<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $user = User::orderBy('name','asc')->get();
        return view('welcome', ['user' => $user]);
    }

    public function loginOnlyPassword($id)
    {
        $user = User::find($id);
        return view('auth.login_only_password', ['user' => $user]);
    }
}
