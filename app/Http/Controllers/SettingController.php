<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return \view('setting.index', [
            'title' => 'Setting'
        ]);
    }

    public function accounts()
    {
        return \view('setting.accounts', [
            'title' => 'Setting / Accounts',
            'accounts' => ChartOfAccount::all()
        ]);
    }
}
