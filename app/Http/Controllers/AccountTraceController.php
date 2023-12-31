<?php

namespace App\Http\Controllers;

use App\Models\AccountTrace;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class AccountTraceController extends Controller
{
    public function index()
    {
        return view('journal/index', [
            'title' => 'Journal Home',
            'accountTrace' => AccountTrace::with('debt', 'cred')->get(),
        ]);
    }

    public function addjournal()
    {
        $accountTrace = new AccountTrace();

        return view('journal/addjournal', [
            'title' => 'Journal / Add Journal',
            'invoice' => $accountTrace->invoice_journal(),
            'account' => ChartOfAccount::all()
        ]);
    }

    public function adddeposit()
    {
        $accountTrace = new AccountTrace();

        return view('journal/adddeposit', [
            'title' => 'Journal / Add Deposit Customer',
            'invoice' => $accountTrace->invoice_journal(),
            'account' => ChartOfAccount::all()
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'waktu' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160|min:5|string',
        ]);

        $accountTrace = new AccountTrace();
        $accountTrace->waktu = $request->waktu;
        $accountTrace->invoice = $accountTrace->invoice_journal();
        $accountTrace->debt_code = $request->debt_code;
        $accountTrace->cred_code = $request->cred_code;
        $accountTrace->jumlah = $request->amount;
        $accountTrace->description = $request->description;
        $accountTrace->user_id = Auth()->user()->id;
        $accountTrace->warehouse_id = Auth()->user()->warehouse_id;
        $accountTrace->save();



        return redirect('/jurnal')->with('success', 'Data Berhasil Diinputkan');
    }

    public function edit($id)
    {
        $accountTrace = AccountTrace::find($id);
        return view('journal/edit', [
            'title' => 'Journal / Edit Journal',
            'account' => ChartOfAccount::all()
        ], compact('accountTrace'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'waktu' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160|min:5|string',
        ]);

        $accountTrace = AccountTrace::find($id);
        $accountTrace->waktu = $request->waktu;
        $accountTrace->debt_code = $request->debt_code;
        $accountTrace->cred_code = $request->cred_code;
        $accountTrace->jumlah = $request->amount;
        $accountTrace->description = $request->description . ' (Edited)';
        $accountTrace->user_id = Auth()->user()->id;
        $accountTrace->save();

        return redirect('/jurnal');
    }

    public function destroy($id)
    {
        $accountTrace = AccountTrace::find($id);
        $accountTrace->delete();
        return redirect('/jurnal');
    }
}
