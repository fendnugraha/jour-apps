<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index', [
            'title' => 'Setting',
            'setting' => Setting::first(),
            'user' => User::where('id', auth()->user()->id)->first(),
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/setting/general')->with('error', 'User not found.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'warehouse' => 'required|exists:warehouses,id',
            'role' => 'required',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->warehouse_id = $request->warehouse;
        $user->role = $request->role;
        $user->save();

        if ($request->newPassword) {
            if (!Hash::check($request->password, $user->password)) {
                return redirect('/setting/general')->with('error', 'Old password not match.');
            }

            $request->validate([
                'newPassword' => 'required|min:8',
                'cNewPassword' => 'required|same:newPassword',
            ]);

            $user->password = bcrypt($request->newPassword);
            $user->save();
            return redirect('/setting/general')->with('success', 'User password updated successfully.');
        }

        return redirect('/setting/general')->with('success', 'User updated successfully.');
    }
}
