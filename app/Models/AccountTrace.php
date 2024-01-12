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
            ->get();

        $debit = $transaction->where('debt_code', $account_code)->sum('amount');
        $kredit = $transaction->where('cred_code', $account_code)->sum('amount');

        if ($debit == null) {
            $debit = 0;
        }
        if ($kredit == null) {
            $kredit = 0;
        }

        if ($initBalance->Account->status == "D") {
            return $initBalance->st_balance + $debit - $kredit;
        } else {
            return $initBalance->st_balance + $kredit - $debit;
        }
    }

    public function profitLossCount($start_date, $end_date)
    {
        $coa = ChartOfAccount::all();

        foreach ($coa as $key => $value) {
            $value->balance = $this->endBalanceBetweenDate($value->acc_code, $start_date, $end_date);
        }

        $revenue = $coa->WhereIn('account_id', \range(27, 30))->sum('balance');
        $cost = $coa->WhereIn('account_id', ['31', '32'])->sum('balance');
        $expense = $coa->WhereIn('account_id', \range(33, 45))->sum('balance');

        ChartOfAccount::Where('acc_code', '30100-002')->update(['st_balance' => $revenue - $cost - $expense]);

        return $revenue - $cost - $expense;
    }

    public function equityCount($end_date)
    {
        $coa = ChartOfAccount::all();

        foreach ($coa as $key => $value) {
            $value->balance = $this->endBalanceBetweenDate($value->acc_code, '0000-00-00', $end_date);
        }

        $initBalance = $coa->Where('acc_code', '30100-001')->first()->st_balance;
        $assets = $coa->WhereIn('account_id', \range(1, 18))->sum('balance');
        $liabilities = $coa->WhereIn('account_id', \range(19, 25))->sum('balance');
        $equity = $coa->Where('account_id', 26)->sum('balance');

        ChartOfAccount::Where('acc_code', '30100-001')->update(['st_balance' => $initBalance + $assets - $liabilities - $equity]);

        return $initBalance + $assets - $liabilities - $equity;
    }
}
