<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountTrace extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'float', // Adjust this based on your actual data type
    ];

    public function receivable()
    {
        return $this->belongsTo(Receivable::class, 'invoice', 'invoice')->where('payment_nth', 'payment_nth');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function debt()
    {
        return $this->belongsTo(ChartOfAccount::class, 'debt_code', 'acc_code');
    }

    public function cred()
    {
        return $this->belongsTo(ChartOfAccount::class, 'cred_code', 'acc_code');
    }

    public function invoice_journal()
    {
        $lastInvoice = DB::table('account_traces')
            ->select(DB::raw('MAX(RIGHT(invoice,7)) AS kd_max'))
            ->where([
                ['user_id', Auth()->user()->id],
            ])
            ->whereDate('created_at', date('Y-m-d'))
            ->get();

        $kd = "";
        if ($lastInvoice[0]->kd_max != null) {
            $no = $lastInvoice[0]->kd_max;
            $kd = $no + 1;
        } else {
            $kd = "0000001";
        }
        return 'JR.BK.' . date('dmY') . '.' . Auth()->user()->id . '.' . \sprintf("%07s", $kd);
    }

    public function endBalanceBetweenDate($account_code, $start_date, $end_date)
    {
        $initBalance = ChartOfAccount::with('account', 'account_trace', 'debt', 'cred')->where('acc_code', $account_code)->first();
        $transaction = $this->whereBetween('date_issued', [
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

        $debit = $transaction->where('debt_code', $account_code)->sum('amount');
        $kredit = $transaction->where('cred_code', $account_code)->sum('amount');

        if ($initBalance->Account->status == "D") {
            return $initBalance->st_balance + $debit - $kredit;
        } else {
            return $initBalance->st_balance + $kredit - $debit;
        }
    }

    public function profitLossCount($start_date, $end_date)
    {
        // Use relationships if available
        $start_date = Carbon::parse($start_date)->copy()->startOfDay();
        $end_date = Carbon::parse($end_date)->copy()->endOfDay();

        $coa = ChartOfAccount::with(['account', 'debt', 'cred'])->whereIn('account_id', \range(27, 45))->get();

        $transactions = $this->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereBetween('date_issued', [$start_date, $end_date])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        foreach ($coa as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');
            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $value->balance = ($value->account->status == "D") ? ($value->st_balance + $debit - $credit) : ($value->st_balance + $credit - $debit);
        }

        // Use collections for filtering
        $revenue = $coa->whereIn('account_id', \range(27, 30))->sum('balance');
        $cost = $coa->whereIn('account_id', \range(31, 32))->sum('balance');
        $expense = $coa->whereIn('account_id', \range(33, 45))->sum('balance');

        // Use Eloquent to update a specific record if it exists
        $specificRecord = ChartOfAccount::where('acc_code', '30100-002')->first();
        if ($specificRecord) {
            $specificRecord->update(['st_balance' => $revenue - $cost - $expense]);
        }

        // Return the calculated profit or loss
        return $revenue - $cost - $expense;
    }



    public function equityCount($end_date, $includeEquity = true)
    {
        $coa = ChartOfAccount::all();

        foreach ($coa as $coaItem) {
            $coaItem->balance = $this->endBalanceBetweenDate($coaItem->acc_code, '0000-00-00', $end_date);
        }

        $initBalance = $coa->where('acc_code', '30100-001')->first()->st_balance;
        $assets = $coa->whereIn('account_id', \range(1, 18))->sum('balance');
        $liabilities = $coa->whereIn('account_id', \range(19, 25))->sum('balance');
        $equity = $coa->where('account_id', 26)->sum('balance');

        // Use Eloquent to update a specific record
        ChartOfAccount::where('acc_code', '30100-001')->update(['st_balance' => $initBalance + $assets - $liabilities - $equity]);

        // Return the calculated equity
        return ($includeEquity ? $initBalance : 0) + $assets - $liabilities - ($includeEquity ? $equity : 0);
    }

    public function cashflowCount($start_date, $end_date)
    {
        $cashAccount = ChartOfAccount::with('account', 'account_trace')->get();

        $transactions = $this->with(['debt', 'cred'])
            ->selectRaw('debt_code, cred_code, SUM(amount) as total')
            ->whereBetween('date_issued', [$start_date, $end_date])
            ->groupBy('debt_code', 'cred_code')
            ->get();

        foreach ($cashAccount as $value) {
            $debit = $transactions->where('debt_code', $value->acc_code)->sum('total');

            $credit = $transactions->where('cred_code', $value->acc_code)->sum('total');

            $value->balance = $debit - $credit;
        }

        $result = $cashAccount->whereIn('account_id', [1, 2])->sum('balance');

        return $result;
    }
}
