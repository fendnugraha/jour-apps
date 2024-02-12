<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\AccountTrace;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;

class ReportController extends Controller
{
    public function index()
    {
        $accountTrace = new AccountTrace();
        $endDate = Carbon::now()->endOfDay();

        $transactions = $accountTrace->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1)->endOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        $chartOfAccounts = ChartOfAccount::with(['account'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        $assets = $chartOfAccounts->whereIn('account_id', \range(1, 18));
        $liabilities = $chartOfAccounts->whereIn('account_id', \range(19, 25));
        $equity = $chartOfAccounts->where('account_id', 26);
        $cash = $chartOfAccounts->where('account_id', 1);
        $bank = $chartOfAccounts->where('account_id', 2);

        $totalCash = $cash->sum('balance') + $bank->sum('balance');

        $receivable = $chartOfAccounts->whereIn('account_id', [4, 5])->groupBy('account_id');
        $payable = $chartOfAccounts->whereIn('account_id', [19, 20])->groupBy('account_id');

        $revenue = $chartOfAccounts->whereIn('account_id', \range(27, 30));
        $cost = $chartOfAccounts->whereIn('account_id', [31, 32]);
        $expense = $chartOfAccounts->whereIn('account_id', \range(33, 45));

        $netProfit = $revenue->sum('balance') - $cost->sum('balance') - $expense->sum('balance');

        $debtRatio = \round($liabilities->sum('balance') / $assets->sum('balance') * 100, 2);
        $currentRatio = \round($assets->sum('balance') / $liabilities->sum('balance') * 100, 2);
        $quickRatio = \round($totalCash / $liabilities->sum('balance') * 100, 2);

        $debtToEquityRatio = \round($liabilities->sum('balance') / $equity->sum('balance') * 100, 2);
        $returnToEquityRatio = \round($netProfit / $equity->sum('balance') * 100, 2);
        $netProfitMarginRation = \round($netProfit / $revenue->sum('balance') * 100, 2);

        return view('report.index', [
            'title' => 'Reports',
            'active' => 'reports',
            'assets' => $assets,
            'liabilities' => $liabilities,
            'equity' => $equity,
            'cash' => $cash,
            'bank' => $bank,
            'totalCash' => $totalCash,
            'receivable' => $receivable,
            'payable' => $payable,
            'revenue' => $revenue,
            'cost' => $cost,
            'expense' => $expense,
            'netProfit' => $netProfit,
            'debtRatio' => $debtRatio,
            'currentRatio' => $currentRatio,
            'quickRatio' => $quickRatio,
            'debtToEquityRatio' => $debtToEquityRatio,
            'returnToEquityRatio' => $returnToEquityRatio,
            'netProfitMarginRation' => $netProfitMarginRation,
        ]);
    }

    public function generalLedger(Request $request)
    {
        $accountTrace = new AccountTrace();
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $account_trace = $accountTrace->with('debt', 'cred', 'warehouse', 'user')->where('debt_code', $request->accounts)
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->orWhere('cred_code', $request->accounts)
            ->WhereBetween('date_issued', [$startDate, $endDate])
            ->orderBy('date_issued', 'asc')
            ->get();

        $debt_total = $account_trace->where('debt_code', $request->accounts)->sum('amount');
        $cred_total = $account_trace->where('cred_code', $request->accounts)->sum('amount');

        $initBalanceDate = Carbon::parse($startDate)->subDays(1)->endOfDay();
        $initBalance = $accountTrace->endBalanceBetweenDate($request->accounts, '0000-00-00', $initBalanceDate);
        $endBalance = $accountTrace->endBalanceBetweenDate($request->accounts, '0000-00-00', $request->end_date);

        return view('report.general-ledger', [
            'title' => 'General Ledger',
            'active' => 'reports',
            'account_trace' => $account_trace,
            'account' => ChartOfAccount::with(['account'])->orderBy('acc_code', 'asc')->get(),
            'debt_total' => $debt_total,
            'cred_total' => $cred_total,
            'initBalance' => $initBalance,
            'endBalance' => $endBalance,
            'status' => ChartOfAccount::with(['account'])->where('acc_code', $request->accounts)->first()->account->status
        ])->with($request->all());
    }

    public function cashflow(Request $request)
    {
        $accountTrace = new AccountTrace();
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();

        $chartOfAccounts = ChartOfAccount::with(['account'])->get();
        $cashBank = $chartOfAccounts->whereIn('account_id', [1, 2]);

        $transactions = $accountTrace->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereIn('debt_code', $cashBank->pluck('acc_code'))
            ->whereBetween('date_issued', [$start_date, $end_date])
            ->orWhereIn('cred_code', $cashBank->pluck('acc_code'))
            ->whereBetween('date_issued', [$start_date, $end_date])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('cred_code', $value->acc_code)
                ->sum('total');
            $credit = $transactions->where('debt_code', $value->acc_code)
                ->sum('total');

            $value->balance = $debit - $credit;
        }

        $initBalance = $chartOfAccounts->whereIn('account_id', [1, 2])->sum('st_balance');

        $startBalance = $initBalance + $accountTrace->cashflowCount('0000-00-00', $start_date);
        $endBalance = $initBalance + $accountTrace->cashflowCount('0000-00-00', $end_date);
        // \dd($end_date->subDay(1), $end_date, $startBalance, $endBalance);

        if ($startBalance == 0) {
            $percentageChange = 0;
        } else {
            $percentageChange = ($endBalance - $startBalance) / $startBalance * 100;
        }

        return view('report.cashflow', [
            'title' => 'Cash Flow',
            'active' => 'reports',
            'pendapatan' => $chartOfAccounts->whereIn('account_id', \range(27, 30))->groupBy('account_id'),
            'piutang' => $chartOfAccounts->whereIn('account_id', [4, 5])->groupBy('account_id'),
            'persediaan' => $chartOfAccounts->whereIn('account_id', [6, 7])->groupBy('account_id'),
            'investasi' => $chartOfAccounts->whereIn('account_id', [10, 11, 12])->groupBy('account_id'),
            'assets' => $chartOfAccounts->whereIn('account_id', [13, 14, 15, 16, 17, 18])->groupBy('account_id'),
            'hutang' => $chartOfAccounts->whereIn('account_id', \range(19, 25))->groupBy('account_id'),
            'modal' => $chartOfAccounts->where('account_id', 26)->groupBy('account_id'),
            'biaya' => $chartOfAccounts->whereIn('account_id', \range(33, 45))->groupBy('account_id'),
            'startBalance' => $startBalance,
            'endBalance' => $endBalance,
            'percentageChange' => $percentageChange,
            'growth' => $endBalance - $startBalance
        ])->with($request->all());
    }

    public function balanceSheet(Request $request)
    {
        $accountTrace = new AccountTrace();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $accountTrace->profitLossCount('0000-00-00', $endDate);

        $transactions = $accountTrace->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1)->endOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        $chartOfAccounts = ChartOfAccount::with(['account'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        $initEquity = $chartOfAccounts->where('acc_code', '30100-001')->first()->st_balance;
        $assets = $chartOfAccounts->whereIn('account_id', \range(1, 18));
        $liabilities = $chartOfAccounts->whereIn('account_id', \range(19, 25));
        $equity = $chartOfAccounts->where('account_id', 26);

        ChartOfAccount::where('acc_code', '30100-001')->update([
            'st_balance' => $initEquity + $assets->sum('balance') - $liabilities->sum('balance') - $equity->sum('balance'),
        ]);

        return view('report.balance-sheet', [
            'title' => 'Balance Sheet',
            'active' => 'reports',
            'assets' => $assets->groupBy('account_id'),
            'liabilities' => $liabilities->groupBy('account_id'),
            'equity' => $equity->groupBy('account_id'),
        ])->with($request->all());
    }


    public function profitLoss(Request $request)
    {
        $accountTrace = new AccountTrace();
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        // $accountTrace->profitLossCount('0000-00-00', $endDate);

        $transactions = $accountTrace->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereBetween('date_issued', [$startDate, $endDate])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        $chartOfAccounts = ChartOfAccount::with(['account'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        return view('report.profit-loss', [
            'title' => 'Profit Loss',
            'active' => 'reports',
            'revenue' => $chartOfAccounts->whereIn('account_id', \range(27, 30))->groupBy('account_id'),
            'cost' => $chartOfAccounts->whereIn('account_id', \range(31, 32))->groupBy('account_id'),
            'expense' => $chartOfAccounts->whereIn('account_id', \range(33, 45))->groupBy('account_id'),
        ])->with($request->all());
    }

    public function dailyProfit(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        // If month and year are not provided in the request, use the current month and year
        if ($month == null && $year == null) {
            $month = Carbon::now()->month;
            $year = Carbon::now()->year;
        }

        $account_trace = new AccountTrace();

        $dailyProfits = [];
        $sumRevenue = 0; // Variable to store the total sum of revenue
        $sumCost = 0;    // Variable to store the total sum of cost
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $tprofit = 0;

        for ($x = 1; $x <= $days; $x++) {
            $date = Carbon::parse("$year-$month-$x")->startOfDay();
            $endDate = Carbon::parse("$year-$month-$x")->endOfDay();

            $revenue = $account_trace->load('debt', 'cred')
                ->whereBetween('date_issued', [$date, $endDate])
                ->where('cred_code', 'LIKE', '4%')
                ->sum('amount');

            $cost = $account_trace->load('debt', 'cred')
                ->whereBetween('date_issued', [$date, $endDate])
                ->where('debt_code', 'LIKE', '5%')
                ->sum('amount');

            $dailyProfits[] = [
                'date' => $date->format('l, d'),
                'revenue' => $revenue,
                'cost' => $cost,
                'profit' => $revenue - $cost,
            ];

            $sumRevenue += $revenue;
            $sumCost += $cost;
            $tprofit += ($revenue - $cost);
        }

        return view('report.daily-profit', [
            'title' => 'Daily Profit',
            'active' => 'reports',
            'monthName' => Carbon::parse($year . '-' . $month . '-01')->format('F'),
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'dailyProfits' => $dailyProfits,
            'sumRevenue' => $sumRevenue,
            'sumCost' => $sumCost, // Add the sum of cost to the view data
            'totalProfit' => $tprofit,
        ])->with($request->all());
    }

    public function cashBankReport(Request $request)
    {
        $accountTrace = new AccountTrace();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        $transactions = $accountTrace->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereBetween('date_issued', [Carbon::create(0000, 1, 1)->endOfDay(), $endDate])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        $chartOfAccounts = ChartOfAccount::with(['account'])->get();

        foreach ($chartOfAccounts as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        $cashBank = $chartOfAccounts->whereIn('account_id', \range(1, 2));

        return view('report.cash-bank', [
            'title' => 'Cash Bank',
            'active' => 'reports',
            'cashBank' => $cashBank->groupBy('account_id'),
        ])->with($request->all());
    }
}
