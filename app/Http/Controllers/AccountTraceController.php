<?php

namespace App\Http\Controllers;

use App\Models\AccountTrace;
use Illuminate\Http\Request;

class AccountTraceController extends Controller
{
    public function index()
    {
        return view('home/index', [
            'title' => 'Home'
        ]);
    }

    public function jurnal()
    {
        return view('home/jurnal', [
            'title' => 'Jurnal',
            'accountTrace' => AccountTrace::all()
        ]);
    }
}
