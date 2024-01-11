<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\AccountTrace;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;

class ReportController extends Controller
{
    public function index()
    {
        return view('settings.reports.index', [
            'title' => 'Reports',
            'active' => 'reports',
            'reports' => Report::all()
        ]);
    }

    public function generalLedger(Request $request)
    {
        if ($request->get('from') && $request->get('to' && $request->get('account'))) {
            $account_trace = AccountTrace::where('debt_code', $request->get('account'))
                ->orWhere('cred_code', $request->get('account'))
                ->whereBetween('date(date_issued)', [$request->get('from'), $request->get('to')])
                ->orderBy('date_issued', 'asc')->get();
        } else {
            $account_trace = AccountTrace::whereBetween('date(date_issued)', [\date('Y-m-d', strtotime('-1 day')), \date('Y-m-d')])->orderBy('date_issued', 'asc')->get();
        }

        return view('report.general-ledger', [
            'title' => 'General Ledger',
            'active' => 'reports',
            'account_trace' => $account_trace,
            'account' => ChartOfAccount::all()
        ]);
    }
}
