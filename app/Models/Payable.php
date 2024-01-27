<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payable extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_code', 'acc_code');
    }

    public function accountTrace()
    {
        return $this->belongsTo(AccountTrace::class, 'invoice', 'invoice');
    }


    public function invoice_payable($contact_id)
    {
        $lastInvoice = DB::table('payables')
            ->select(DB::raw('MAX(RIGHT(invoice,7)) AS kd_max'))
            ->where([
                ['contact_id', $contact_id],
            ])
            ->whereDate('created_at', date('Y-m-d'))
            ->get();

        $kd = "";
        if ($lastInvoice[0]->kd_max != null) {
            $tmp = ((int)$lastInvoice[0]->kd_max) + 1;
            $kd = sprintf("%07s", $tmp);
        } else {
            $kd = "0000001";
        }

        return 'PY.BK.' . date('dmY') . '.' . $contact_id . '.' . $kd;
    }
}
