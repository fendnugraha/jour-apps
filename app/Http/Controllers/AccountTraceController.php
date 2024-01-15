<?php

namespace App\Http\Controllers;

use App\Models\AccountTrace;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;

class AccountTraceController extends Controller
{
    public function index()
    {
        return view('journal/index', [
            'title' => 'Journal Home',
            'accountTrace' => AccountTrace::with(['debt', 'cred', 'warehouse', 'user'])->orderBy('id', 'desc')->get(),
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
            'account' => ChartOfAccount::all()
        ]);
    }

    public function addSalesValues()
    {
        $accountTrace = new AccountTrace();

        return view('journal/addSalesValues', [
            'title' => 'Journal / Add Sales Values',
            'account' => ChartOfAccount::whereIn('account_id', [1, 2, 19])->get()
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'date_issued' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160|min:5|string',
        ]);

        $accountTrace = new AccountTrace();
        $accountTrace->date_issued = $request->date_issued;
        $accountTrace->invoice = $accountTrace->invoice_journal();
        $accountTrace->debt_code = $request->debt_code;
        $accountTrace->cred_code = $request->cred_code;
        $accountTrace->amount = $request->amount;
        $accountTrace->description = $request->description;
        $accountTrace->user_id = Auth()->user()->id;
        $accountTrace->warehouse_id = Auth()->user()->warehouse_id;
        $accountTrace->save();



        return redirect('/jurnal')->with('success', 'Data Berhasil Diinputkan');
    }

    public function storeSalesValues(Request $request)
    {

        $request->validate([
            'date_issued' => 'required',
            'debt_code' => 'required',
            'cost' => 'required|numeric',
            'sales' => 'required|numeric',
            'description' => 'required|max:160|min:5|string',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $accountTrace = new AccountTrace();
                $accountTrace->date_issued = $request->date_issued;
                $accountTrace->invoice = $accountTrace->invoice_journal();
                $accountTrace->debt_code = $request->debt_code;
                $accountTrace->cred_code = '40100-001';
                $accountTrace->amount = $request->sales;
                $accountTrace->description = $request->description;
                $accountTrace->user_id = Auth()->user()->id;
                $accountTrace->warehouse_id = Auth()->user()->warehouse_id;
                $accountTrace->save();

                $accountTrace = new AccountTrace();
                $accountTrace->date_issued = $request->date_issued;
                $accountTrace->invoice = $accountTrace->invoice_journal();
                $accountTrace->debt_code = '50100-001';
                $accountTrace->cred_code = '10600-001';
                $accountTrace->amount = $request->cost;
                $accountTrace->description = $request->description;
                $accountTrace->user_id = Auth()->user()->id;
                $accountTrace->warehouse_id = Auth()->user()->warehouse_id;
                $accountTrace->save();
            });

            return redirect('/jurnal')->with('success', 'Data Berhasil Diinputkan');
        } catch (\Exception $e) {
            return redirect('/jurnal')->back()->with('error', $e->getMessage());
        }
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
            'date_issued' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160|min:5|string',
        ]);

        $accountTrace = AccountTrace::find($id);
        $accountTrace->date_issued = $request->date_issued;
        $accountTrace->debt_code = $request->debt_code;
        $accountTrace->cred_code = $request->cred_code;
        $accountTrace->amount = $request->amount;
        $accountTrace->description = $request->description . ' (Edited)';
        $accountTrace->user_id = Auth()->user()->id;
        $accountTrace->save();

        return redirect('/jurnal')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $accountTrace = AccountTrace::find($id);
        $accountTrace->delete();

        return redirect('/jurnal')->with('success', 'Data Berhasil Dihapus');
    }
}
