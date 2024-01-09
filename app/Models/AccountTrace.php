<?php

namespace App\Models;

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
        return 'JR.BK.' . date('ymd') . '.' . Auth()->user()->id . '.' . \sprintf("%07s", $kd);
    }
}
