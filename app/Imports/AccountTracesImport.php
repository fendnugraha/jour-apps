<?php

namespace App\Imports;

use App\Models\AccountTrace;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AccountTracesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            AccountTrace::create([
                'date_issued' => $row[0],
                'invoice' => $row[1],
                'description' => $row[2],
                'debt_code' => $row[3],
                'cred_code' => $row[4],
                'amount' => $row[5],
                'user_id' => Auth()->user()->id,
                'warehouse_id' => Auth()->user()->warehouse_id
            ]);
        }
    }
}
