<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/login', [
            'title' => 'Member Login'
        ]);
    }

    public function register()
    {
        return view('auth/register', [
            'title' => 'Member Registration'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:90|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|max:60',
            'cpassword' => 'required|same:password'
        ]);

        User::create($validatedData);

        // $request->session()->flash('success', 'Registrasion successfull, Please login!');
        return \redirect('/auth/register_success');
    }
}
