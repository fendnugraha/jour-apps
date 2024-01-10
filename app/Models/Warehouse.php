<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone'];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function ChartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}
