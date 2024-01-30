<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Receivable;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReceivablesExport implements FromQuery, ShouldAutoSize, WithHeadings, WithStyles
{
    use Exportable;

    public function query()
    {
        return Receivable::query()->select(
            DB::raw('receivables.contact_id, min(contacts.name) as name, 
            SUM(bill_amount) as bill, SUM(payment_amount) as payment, 
            SUM(bill_amount - payment_amount) as balance')
        )
            ->join('contacts', 'contacts.id', '=', 'receivables.contact_id')
            ->groupBy('receivables.contact_id');
    }

    public function headings(): array
    {
        return [
            ["Receivable Table Export - Exported at: " . Carbon::now()->format('Y-m-d H:i:s')],
            ["Contact ID", "Name", "Bill", "Payment", "Balance"]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 14]],
            2    => ['font' => ['bold' => true]],
        ];
    }
}
