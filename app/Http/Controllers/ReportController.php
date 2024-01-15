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
        $account_trace = new AccountTrace();
        $test = $account_trace->endBalanceBetweenDate('30100-002', '2024-01-01', '2024-01-01');
        $profit = $account_trace->profitLossCount('2024-01-01', '2024-01-01');

        $account_code = '40100-001';
        $start_date = '2024-01-01';
        $end_date = '2024-01-01';

        $transaction = $account_trace->whereBetween('date_issued', [
            Carbon::parse($start_date)->startOfDay(),
            Carbon::parse($end_date)->endOfDay(),
        ])
            ->where('debt_code', $account_code)
            ->orWhere('cred_code', $account_code)
            ->whereBetween('date_issued', [
                Carbon::parse($start_date)->startOfDay(),
                Carbon::parse($end_date)->endOfDay(),
            ])
            ->get();

        \dd($transaction->toArray());
        return view('report.index', [
            'title' => 'Reports',
            'active' => 'reports',
            'test' => $test,
            'profit' => $profit
        ]);
    }

    public function generalLedger(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->subDay();
        $endDate = \Carbon\Carbon::parse($request->end_date)->addDay();
        $account_trace = AccountTrace::where('debt_code', $request->accounts)
            ->whereBetween('date_issued', [$request->start_date, $endDate])
            ->orWhere('cred_code', $request->accounts)
            ->WhereBetween('date_issued', [$request->start_date, $endDate])
            ->orderBy('date_issued', 'asc')
            ->get();

        if ($request->accounts == null) {
            $account_trace = AccountTrace::whereBetween('date_issued', [$request->start_date, $endDate])
                ->orderBy('date_issued', 'asc')
                ->get();
        }

        $debt_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
            ->where('debt_code', $request->accounts)
            ->whereBetween('date_issued', [$request->start_date, $endDate])
            ->first();

        $cred_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
            ->whereBetween('date_issued', [$request->start_date, $endDate])
            ->where('cred_code', $request->accounts)->first();

        if ($request->accounts == null) {
            $debt_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
                ->whereBetween('date_issued', [$request->start_date, $endDate])
                ->first();
            $cred_total = AccountTrace::select(DB::raw('SUM(amount) as total'))
                ->whereBetween('date_issued', [$request->start_date, $endDate])
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
        $accountTrace = new AccountTrace();
        $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
        // dd($endDate);

        // Process profitLossCount and equityCount first
        $accountTrace->profitLossCount('0000-00-00', $endDate);
        $accountTrace->equityCount($endDate);

        // Fetch transactions
        $transactions = $accountTrace->load('debt', 'cred')
            ->whereBetween('date_issued', [
                '0000-00-00', $endDate,
            ])
            ->get();

        // Fetch chart of accounts
        $chartOfAccounts = ChartOfAccount::with(['account', 'account_trace'])
            ->get();

        // Calculate balances
        foreach ($chartOfAccounts as $coaItem) {
            $debit = $transactions->where('debt_code', $coaItem->acc_code)->sum('amount');
            $credit = $transactions->where('cred_code', $coaItem->acc_code)->sum('amount');

            if ($coaItem->Account->status == "D") {
                $coaItem->balance = $coaItem->st_balance + $debit - $credit;
            } else {
                $coaItem->balance = $coaItem->st_balance + $credit - $debit;
            }
        }

        return view('report.balance-sheet', [
            'title' => 'Balance Sheet',
            'active' => 'reports',
            'assets' => $chartOfAccounts->whereIn('account_id', \range(1, 18))->groupBy('account_id'),
            'liabilities' => $chartOfAccounts->whereIn('account_id', \range(19, 25))->groupBy('account_id'),
            'equity' => $chartOfAccounts->where('account_id', 26)->groupBy('account_id'),
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

            if ($value->Account->status == "D") {
                $value->balance = $debit - $credit;
            } else {
                $value->balance = $credit - $debit;
            }
        }

        return view('report.profit-loss', [
            'title' => 'Profit Loss',
            'active' => 'reports',
            'revenue' => $coa->whereIn('account_id', \range(27, 30))->groupBy('account_id'),
            'cost' => $coa->whereIn('account_id', \range(31, 32))->groupBy('account_id'),
            'expense' => $coa->whereIn('account_id', \range(33, 45))->groupBy('account_id'),
        ])->with($request->all());
    }

    public function cashflowReport(Request $request)
    {
        $account_trace = new AccountTrace();
        $account_trace->profitLossCount('0000-00-00', $request->end_date);
        $account_trace->equityCount($request->end_date);

        $transactions = $account_trace->load('debt', 'cred')
            ->whereBetween('date_issued', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ])->get();

        return view('report.cashflow-report', [
            'title' => 'Cash Flow Report',
            'active' => 'reports',
            'transactions' => $transactions
        ])->with($request->all());
    }
}
