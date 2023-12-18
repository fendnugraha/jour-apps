<?php

namespace App\Models;

use App\Models\ChartOfAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountTrace extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->hasMany(ChartOfAccount::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
