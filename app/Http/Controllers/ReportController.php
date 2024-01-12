<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\AccountTrace;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;

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
        $account_trace = AccountTrace::where('debt_code', $request->accounts)
            ->whereBetween('date_issued', [$request->start_date, $request->end_date])
            ->orWhere('cred_code', $request->accounts)
            ->WhereBetween('date_issued', [$request->start_date, $request->end_date])
            ->orderBy('date_issued', 'asc')
            ->get();

        if ($request->accounts == null) {
            $account_trace = AccountTrace::whereBetween('date_issued', [$request->start_date, $request->end_date])
                ->orderBy('date_issued', 'asc')
                ->get();
        }

        $debt_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
            ->where('debt_code', $request->accounts)
            ->whereBetween('date_issued', [$request->start_date, $request->end_date])
            ->first();

        $cred_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
            ->whereBetween('date_issued', [$request->start_date, $request->end_date])
            ->where('cred_code', $request->accounts)->first();

        if ($request->accounts == null) {
            $debt_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
                ->whereBetween('date_issued', [$request->start_date, $request->end_date])
                ->first();
            $cred_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
                ->whereBetween('date_issued', [$request->start_date, $request->end_date])
                ->first();
        }

        $initBalanceDate = Carbon::parse($request->start_date)->subDays(1)->format('Y-m-d');
        $account_traces = new AccountTrace();
        $initBalance = $account_traces->endBalanceBetweenDate($request->accounts, '0000-00-00', $initBalanceDate);
        $endBalance = $account_traces->endBalanceBetweenDate($request->accounts, '0000-00-00', $request->end_date);

        return view('report.general-ledger', [
            'title' => 'General Ledger',
            'active' => 'reports',
            'account_trace' => $account_trace->load(['debt', 'cred', 'warehouse', 'user']),
            'account' => ChartOfAccount::all(),
            'debt_total' => $debt_total,
            'cred_total' => $cred_total,
            'initBalance' => $initBalance,
            'endBalance' => $endBalance
        ])->with($request->all());
    }

    public function cashflow()
    {
        return view('report.cashflow', [
            'title' => 'Cash Flow',
            'active' => 'reports',
        ]);
    }

    public function balanceSheet(Request $request)
    {
        $coa = ChartOfAccount::with(['account'])
            ->get();

        $account_trace = new AccountTrace();
        $account_trace->profitLossCount('0000-00-00', $request->end_date);
        $account_trace->equityCount($request->end_date);

        $transactions = $account_trace->load('debt', 'cred')
            ->whereBetween('date_issued', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ])
            ->get();

        foreach ($coa as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('amount');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('amount');

            $value->balance = $value->st_balance + $debit - $credit;
        }

        return view('report.balance-sheet', [
            'title' => 'Balance Sheet',
            'active' => 'reports',
            'assets' => $coa->load('account_trace')->whereIn('account_id', \range(1, 18))->groupBy('account_id'),
            'liabilities' => $coa->load('account_trace')->whereIn('account_id', \range(19, 25))->groupBy('account_id'),
            'equity' => $coa->where('account_id', 26)->groupBy('account_id'),
        ], \compact('transactions'))->with($request->all());
    }

    public function profitLoss(Request $request)
    {
        $coa = ChartOfAccount::with(['account'])->get();

        $account_trace = new AccountTrace();
        $account_trace->profitLossCount($request->start_date, $request->end_date);

        $coa->loadMissing('account_trace');

        $transactions = $account_trace->load('debt', 'cred')
            ->whereBetween('date_issued', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ])
            ->get();

        foreach ($coa as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('amount');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('amount');
            $value->balance = $debit - $credit;
        }

        return view('report.profit-loss', [
            'title' => 'Profit Loss',
            'active' => 'reports',
            'revenue' => $coa->whereIn('account_id', \range(27, 30))->groupBy('account_id'),
            'cost' => $coa->whereIn('account_id', \range(31, 32))->groupBy('account_id'),
            'expense' => $coa->whereIn('account_id', \range(33, 45))->groupBy('account_id'),
        ])->with($request->all());
    }
}
