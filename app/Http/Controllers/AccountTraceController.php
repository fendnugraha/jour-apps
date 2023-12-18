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
            'title' => 'Home / Jurnal',
            'accountTrace' => AccountTrace::all()
        ]);
    }

    public function addjournal()
    {
        return view('home/addjournal', [
            'title' => 'Home / Add Journal'
        ]);
    }
}
