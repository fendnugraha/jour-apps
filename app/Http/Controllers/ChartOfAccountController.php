<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $accounts = ChartOfAccount::with('account')->get();

        return view('setting.coa.index', [
            'title' => 'Chart of Accounts',
            'accounts' => $accounts,
        ]);
    }

    public function addaccount()
    {
        return view('setting.coa.add', [
            'title' => 'Add New Chart of Accounts',
            'accounts' => Account::all(),
        ]);
    }

    public function store(Request $request)
    {
        $ChartOfAccount = new ChartOfAccount();

        $request->validate([
            'acc_name' => 'required|max:60|min:5|unique:chart_of_accounts,acc_name',
            'acc_type' => 'required',
            'st_balance' => 'numeric',
        ]);

        ChartOfAccount::create([
            'acc_code' => $ChartOfAccount->acc_code($request->acc_type),
            'acc_name' => $request->acc_name,
            'account_id' => $request->acc_type,
            'st_balance' => $request->st_balance ?? 0,
        ]);

        return redirect('/setting/accounts')->with('success', 'Data Added Successfully');
    }

    public function edit($id)
    {
        $ChartOfAccount = ChartOfAccount::find($id);

        return view('setting.coa.edit', [
            'title' => 'Edit Chart of Accounts',
            'accounts' => Account::all(),
            'coa' => $ChartOfAccount,
        ], compact('ChartOfAccount'));
    }

    public function update(Request $request, $id)
    {
        $ChartOfAccount = ChartOfAccount::find($id);

        $request->validate([
            'acc_name' => 'required|max:60|min:5',
            'st_balance' => 'numeric',
        ]);

        $ChartOfAccount->update([
            'acc_name' => $request->acc_name,
            'st_balance' => $request->st_balance ?? 0,
        ]);

        return redirect('/setting/accounts')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {
        $ChartOfAccount = ChartOfAccount::find($id);
        $ChartOfAccount->delete();
        return redirect('/setting/accounts')->with('success', 'Data Deleted Successfully');
    }
}
