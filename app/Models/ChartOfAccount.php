<?php

namespace App\Models;

use App\Models\Account;
use App\Models\AccountTrace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartOfAccount extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function accounttrace()
    {
        return $this->hasMany(AccountTrace::class, 'debt_code', 'cred_code');
    }
}
