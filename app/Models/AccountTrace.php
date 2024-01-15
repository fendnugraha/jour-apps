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
        $initBalance = ChartOfAccount::with('account')->where('acc_code', $account_code)->first();
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
        $start_date = Carbon::parse($start_date)->startOfDay();
        $end_date = Carbon::parse($end_date)->endOfDay();

        // \dd($start_date, $end_date);
        $coa = ChartOfAccount::all();

        foreach ($coa as $coaItem) {
            // Use a more descriptive variable name
            $coaItem->balance = $this->endBalanceBetweenDate($coaItem->acc_code, $start_date, $end_date);
        }

        // Use collections for filtering
        $revenue = $coa->whereIn('account_id', ['27', '28', '29', '30'])->sum('balance');
        $cost = $coa->whereIn('account_id', ['31', '32'])->sum('balance');
        $expense = $coa->whereIn('account_id', \range(33, 45))->sum('balance');

        // \dd($coa->whereIn('account_id', \range(27, 30))->toArray());

        // Use Eloquent to update a specific record
        ChartOfAccount::where('acc_code', '30100-002')->update(['st_balance' => $revenue - $cost - $expense]);

        // Return the calculated profit or loss
        return $revenue - $cost - $expense;
    }


    public function equityCount($end_date)
    {
        // Use relationships if available
        $coa = ChartOfAccount::all();

        foreach ($coa as $coaItem) {
            // Use a more descriptive variable name
            $coaItem->balance = $this->endBalanceBetweenDate($coaItem->acc_code, '0000-00-00', $end_date);
        }

        // Use collections for filtering
        $initBalance = $coa->firstWhere('acc_code', '30100-001')->st_balance;
        $assets = $coa->whereIn('account_id', \range(1, 18))->groupBy('account_id')->sum('balance');
        $liabilities = $coa->whereIn('account_id', \range(19, 25))->groupBy('account_id')->sum('balance');
        $equity = $coa->where('account_id', 26)->groupBy('account_id')->sum('balance');

        // Use Eloquent to update a specific record
        ChartOfAccount::where('acc_code', '30100-001')->update(['st_balance' => $assets - $liabilities - $equity]);

        // Return the calculated equity
        return $assets - $liabilities - $equity;
    }
}
