<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function receivables()
    {
        return $this->hasMany(Receivable::class);
    }

    public function payables()
    {
        return $this->hasMany(Payable::class);
    }
}
