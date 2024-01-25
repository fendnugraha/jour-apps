<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\AccountTrace;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class ReportController extends Controller
{
    public function index()
    {
        $endDate = \Carbon\Carbon::parse(now())->endOfDay();
        // Eager loading relationships
        $accountTrace = AccountTrace::with(['debt', 'cred', 'debt.account', 'cred.account'])
            ->whereBetween('date_issued', ['0000-00-00', $endDate])
            ->latest()
            ->get();



        // Fetch transactions
        // $transactions = $accountTrace->load('debt', 'cred')
        //     ->whereBetween('date_issued', [
        //         '0000-00-00', $endDate,
        //     ])->get();

        // Fetch chart of accounts
        $chartOfAccounts = ChartOfAccount::all();

        // Calculate balances
        foreach ($chartOfAccounts as $coaItem) {
            $debit = $accountTrace->where('debt_code', $coaItem->acc_code)->sum('amount');
            $credit = $accountTrace->where('cred_code', $coaItem->acc_code)->sum('amount');

            if ($coaItem->Account->status == "D") {
                $coaItem->balance = $coaItem->st_balance + $debit - $credit;
            } else {
                $coaItem->balance = $coaItem->st_balance + $credit - $debit;
            }
        }

        $assets = $chartOfAccounts->load('account')->whereIn('account_id', \range(1, 18));
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
            'account' => ChartOfAccount::with(['account'])->orderBy('acc_code', 'asc')->get(),
            'debt_total' => $debt_total,
            'cred_total' => $cred_total,
            'initBalance' => $initBalance,
            'endBalance' => $endBalance
        ])->with($request->all());
    }

    public function cashflow(Request $request)
    {
        $chartOfAccounts = ChartOfAccount::with(['account', 'account_trace'])
            ->get();
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();

        foreach ($chartOfAccounts as $value) {
            $debit = AccountTrace::where('debt_code', 'LIKE', '10100%')
                ->where('cred_code', $value->acc_code)
                ->whereBetween('date_issued', [$start_date, $end_date])
                ->orWhere('debt_code', 'LIKE', '10200%')
                ->where('cred_code', $value->acc_code)
                ->whereBetween('date_issued', [$start_date, $end_date])
                ->sum('amount');

            $credit = AccountTrace::where('cred_code', 'LIKE', '10100%')
                ->where('debt_code', $value->acc_code)
                ->whereBetween('date_issued', [$start_date, $end_date])
                ->orWhere('cred_code', 'LIKE', '10200%')
                ->where('debt_code', $value->acc_code)
                ->whereBetween('date_issued', [$start_date, $end_date])
                ->sum('amount');

            $value->balance = $debit - $credit;
        }

        $initBalance = $chartOfAccounts->whereIn('account_id', [1, 2])->sum('st_balance');

        $account_trace = new AccountTrace();
        $startBalance = $initBalance + $account_trace->cashflowCount('0000-00-00', $start_date->subDay(1));
        $endBalance = $initBalance + $account_trace->cashflowCount('0000-00-00', $end_date);

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
        $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();
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
        $data = [];
        for ($x = 1; $x <= $days; $x++) {
            $date = Carbon::parse("$year-$month-$x")->startOfDay();
            $endDate = Carbon::parse("$year-$month-$x")->endOfDay();

            $revenue = $account_trace->with('debt', 'cred')
                ->whereBetween('date_issued', [$date, $endDate])
                ->where('cred_code', 'LIKE', '4%')
                ->sum('amount');

            $cost = $account_trace->with('debt', 'cred')
                ->whereBetween('date_issued', [$date, $endDate])
                ->where('debt_code', 'LIKE', '5%')
                ->sum('amount');

            $data[] = [
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
            'data' => $data,
            'sumRevenue' => $sumRevenue,
            'sumCost' => $sumCost, // Add the sum of cost to the view data
            'totalProfit' => $tprofit,
        ])->with($request->all());
    }
}
