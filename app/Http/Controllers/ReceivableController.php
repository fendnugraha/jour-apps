<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Contact;
use App\Models\Receivable;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    public function index()
    {
        $receivable = Receivable::all();
        return view('journal.receivable.index', [
            'title' => 'Receivable',
            'receivables' => $receivable
        ]);
    }

    public function addReceivable()
    {
        $coa = ChartOfAccount::where('account_id', 4)->get();
        return view('journal.receivable.addReceivable', [
            'title' => 'Add Receivable',
            'contacts' => Contact::all(),
            'accounts' => $coa
        ]);
    }
}
