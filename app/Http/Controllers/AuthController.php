<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if ($request->logged_in !== null) {
            return \redirect('/setting/users')->with('success', 'Registrasion successfull, Please login!');
        } else {
            return \redirect('/auth/register_success');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            User::where('id', Auth::id())->update(['last_login' => now()]);
            return \redirect()->intended('/jurnal');
        }

        return back()->with([
            'login_error' => 'Username or Password is wrong, please try again or Register new account!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect('/');
    }

    public function users()
    {
        $users = User::with('warehouse')->get();
        return view('setting/users/index', [
            'title' => 'User Management',
            'users' => $users
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('setting/users/edit', [
            'title' => 'Edit User',
            'user' => $user,
            'warehouses' => Warehouse::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'warehouse' => 'required|exists:warehouses,id',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect('/setting/users')->with('error', 'User not found.');
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->warehouse_id = $request->warehouse;
        $user->save();

        return redirect('/setting/users')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/setting/users')->with('success', 'User deleted successfully.');
    }
}
