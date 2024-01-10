<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Receivable;
use App\Models\AccountTrace;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\Console;

use function Laravel\Prompts\alert;

class ReceivableController extends Controller
{
    public function index()
    {
        $bill_total = Receivable::select(
            DB::raw('receivables.contact_id, SUM(bill_amount) as bill, SUM(payment_amount) as payment, SUM(bill_amount - payment_amount) as balance')
        )
            ->join('contacts', 'contacts.id', '=', 'receivables.contact_id')
            ->groupBy('receivables.contact_id')
            ->get();

        // dd($bill_total);

        return view('journal.receivable.index', [
            'title' => 'Receivable',
            'bill_total' => $bill_total,
        ]);
    }

    public function invoice()
    {
        return view('journal.receivable.invoice', [
            'title' => 'Receivable Invoice',
            'contacts' => Contact::all(),
        ]);
    }

    public function addReceivable()
    {
        $coa = ChartOfAccount::where('account_id', 4)->get();
        $rscFund = ChartOfAccount::whereIn('account_id', [1, 2, 6])->get();

        return view('journal.receivable.addReceivable', [
            'title' => 'Add Receivable',
            'contacts' => Contact::all(),
            'rcv' => $coa,
            'rscFund' => $rscFund
        ]);
    }

    public function addReceivableDeposit()
    {
        $coa = ChartOfAccount::where('account_id', 4)->get();

        return view('journal.receivable.addReceivableDeposit', [
            'title' => 'Add Receivable Deposit',
            'contacts' => Contact::all(),
            'rcv' => $coa,
        ]);
    }

    public function addReceivableSales()
    {
        $coa = ChartOfAccount::where('account_id', 4)->get();

        return view('journal.receivable.addReceivableSales', [
            'title' => 'Add Receivable Sales',
            'contacts' => Contact::all(),
            'rcv' => $coa,
        ]);
    }

    public function storeReceivableSales(Request $request)
    {
        $request->validate([
            'date_issued' => 'required',
            'cost' => 'required|numeric',
            'sales' => 'required|numeric',
            'description' => 'required|max:160',
            'contact' => 'required',
            'debt_code' => 'required',
        ]);

        try {
            $dateIssued = Carbon::parse($request->date_issued);
            $rcv = new Receivable();
            $invoice_number = $rcv->invoice_receivable($request->contact);

            DB::transaction(function () use ($request, $invoice_number, $dateIssued) {
                Receivable::create([
                    'date_issued' => $dateIssued,
                    'due_date' => $dateIssued->copy()->addDays(30),
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'bill_amount' => $request->sales,
                    'payment_amount' => 0,
                    'payment_status' => 0,
                    'payment_nth' => 0,
                    'contact_id' => $request->contact,
                    'account_code' => $request->debt_code
                ]);

                $account_trace = [
                    [
                        'date_issued' => $dateIssued,
                        'invoice' => $invoice_number,
                        'description' => $request->description,
                        'debt_code' => $request->debt_code,
                        'cred_code' => '40100-001',
                        'amount' => $request->sales,
                        'status' => 1,
                        'rcv_pay' => 'Receivable',
                        'payment_status' => 0,
                        'payment_nth' => 0,
                        'user_id' => auth()->user()->id,
                        'warehouse_id' => auth()->user()->warehouse_id
                    ],
                    [
                        'date_issued' => $dateIssued,
                        'invoice' => $invoice_number,
                        'description' => $request->description,
                        'debt_code' => '50100-001',
                        'cred_code' => '10600-001',
                        'amount' => $request->cost,
                        'status' => 1,
                        'rcv_pay' => 'Receivable',
                        'payment_status' => 0,
                        'payment_nth' => 0,
                        'user_id' => auth()->user()->id,
                        'warehouse_id' => auth()->user()->warehouse_id
                    ],
                ];

                AccountTrace::insert($account_trace);
            });

            return redirect('/piutang')->with('success', 'Receivable added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_issued' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160',
            'contact' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
        ]);

        try {
            $dateIssued = Carbon::parse($request->date_issued);
            $rcv = new Receivable();
            $invoice_number = $rcv->invoice_receivable($request->contact);

            DB::transaction(function () use ($request, $invoice_number, $dateIssued) {
                Receivable::create([
                    'date_issued' => $dateIssued,
                    'due_date' => $dateIssued->copy()->addDays(30),
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'bill_amount' => $request->amount,
                    'payment_amount' => 0,
                    'payment_status' => 0,
                    'payment_nth' => 0,
                    'contact_id' => $request->contact,
                    'account_code' => $request->debt_code
                ]);

                AccountTrace::create([
                    'date_issued' => $dateIssued,
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'debt_code' => $request->debt_code,
                    'cred_code' => $request->cred_code,
                    'amount' => $request->amount,
                    'status' => 1,
                    'rcv_pay' => 'Receivable',
                    'payment_status' => 0,
                    'payment_nth' => 0,
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => auth()->user()->warehouse_id
                ]);
            });

            return redirect('/piutang')->with('success', 'Receivable added successfully');
        } catch (\Exception $e) {
            return redirect('/piutang')->with('error', 'Receivable added failed');
        }
    }

    public function detail($id)
    {
        $rcvs = Receivable::select(
            'contact_id',
            DB::raw('SUM(bill_amount) as bill'),
            DB::raw('SUM(payment_amount) as payment'),
            DB::raw('SUM(bill_amount - payment_amount) as balance')
        )
            ->where('contact_id', $id)
            ->groupBy('contact_id')
            ->first();

        $rcv = Receivable::select('receivables.*')
            ->join('chart_of_accounts', 'receivables.account_code', '=', 'chart_of_accounts.acc_code')
            ->where('receivables.contact_id', $id)
            ->orderBy('receivables.date_issued', 'desc')
            ->get();

        $invoices = $rcv->pluck('invoice')->toArray();
        $balances = Receivable::selectRaw('invoice, SUM(bill_amount) - SUM(payment_amount) AS balance')
            ->whereIn('invoice', $invoices)
            ->groupBy('invoice')
            ->pluck('balance', 'invoice');

        $rscFund = ChartOfAccount::whereIn('account_id', [1, 2, 6, 19, 26])->get();

        if (!$rcvs) {
            return redirect()->back()->with('error', 'Receivable not found');
        }

        return view('journal.receivable.detail', [
            'title' => 'Receivable Detail',
            'rcv' => $rcv,
            'rcvs' => $rcvs,
            'invoices' => $invoices,
            'balances' => $balances,
            'rscFund' => $rscFund
        ]);
    }

    public function storePayment(Request $request)
    {
        $rcv = Receivable::selectRaw('SUM(bill_amount) - SUM(payment_amount) AS balance')
            ->where('invoice', $request->invoice)
            ->groupBy('invoice')
            ->first();

        $dtRcv = Receivable::where([
            ['invoice', $request->invoice],
            ['payment_nth', 0],
        ])->first();

        $request->validate([
            'invoice' => 'required',
            'amount' => 'required|numeric|max:' . $rcv->balance,
            'description' => 'required|max:160',
            'debt_code' => 'required',
            'date_issued' => 'required',
        ]);

        try {

            // if($rcv->balance - $request->amount > 0){ {
            //     return redirect('/piutang/' . $rcv->contact_id . '/detail')->with('error', 'Receivable balance not enough');
            // }

            $dateIssued = Carbon::parse($request->date_issued);
            $invoice_number = $request->invoice;
            $payment_status = $rcv->balance - $request->amount == 0 ? 1 : 0;
            $payment_nth = Receivable::selectRaw('MAX(payment_nth) as nth')->where('invoice', $request->invoice)->first('nth')->nth + 1;

            DB::transaction(function () use ($request, $invoice_number, $dateIssued, $payment_status, $payment_nth, $dtRcv) {
                Receivable::create([
                    'date_issued' => $dateIssued,
                    'due_date' => $dtRcv->due_date,
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'bill_amount' => 0,
                    'payment_amount' => $request->amount,
                    'payment_status' => $payment_status,
                    'payment_nth' => $payment_nth,
                    'contact_id' => $dtRcv->contact_id,
                    'account_code' => $request->debt_code
                ]);

                AccountTrace::create([
                    'date_issued' => $dateIssued,
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'debt_code' => $request->debt_code,
                    'cred_code' => $dtRcv->account_code,
                    'amount' => $request->amount,
                    'status' => 1,
                    'rcv_pay' => 'Receivable',
                    'payment_status' => $payment_status,
                    'payment_nth' => $payment_nth,
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => auth()->user()->warehouse_id
                ]);
            });

            return redirect('/piutang/' . $dtRcv->contact_id . '/detail')->with('success', 'Receivable added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function editDetail($id)
    {
        $rcv = Receivable::with('accountTrace', 'contact', 'account')->find($id);
        $account_trace = AccountTrace::with('debt', 'cred')->where([
            ['invoice', $rcv->invoice],
            ['payment_nth', $rcv->payment_nth]
        ])->first();

        if (!$rcv) {
            return redirect()->back()->with('error', 'Receivable not found');
        }

        $rscFund = ChartOfAccount::whereIn('account_id', [1, 2, 6, 19, 26])->get();

        return view('journal.receivable.update', [
            'title' => 'Edit Receivable',
            'rcv' => $rcv,
            'rscFund' => $rscFund,
            'rsvAccount' => ChartOfAccount::where('account_id', 4)->get(),
            'contacts' => Contact::all(),
            'account_trace' => $account_trace
        ]);
    }

    public function updateDetail(Request $request, $id)
    {
        $rcv = Receivable::find($id);

        if (!$rcv) {
            return redirect()->back()->with('error', 'Receivable not found');
        }

        $request->validate([
            'date_issued' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160',
            'contact' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
        ]);

        try {

            $dateIssued = Carbon::parse($request->date_issued);
            $invoice_number = $rcv->invoice;
            $payment_status = $rcv->balance - $request->amount == 0 ? 1 : 0;
            $payment_nth = $rcv->payment_nth;

            DB::transaction(function () use ($request, $invoice_number, $dateIssued, $payment_status, $payment_nth, $rcv) {

                $rcv->update([
                    'date_issued' => $dateIssued,
                    'due_date' => $dateIssued->copy()->addDays(30),
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'bill_amount' => 0,
                    'payment_amount' => $request->amount,
                    'payment_status' => $payment_status,
                    'payment_nth' => $payment_nth,
                    'contact_id' => $request->contact,
                    'account_code' => $request->debt_code
                ]);

                AccountTrace::where('invoice', $invoice_number)
                    ->where('payment_nth', $payment_nth)
                    ->update([
                        'date_issued' => $dateIssued,
                        'invoice' => $invoice_number,
                        'description' => $request->description,
                        'debt_code' => $request->debt_code,
                        'cred_code' => $rcv->account_code,
                        'amount' => $request->amount,
                        'status' => 1,
                        'rcv_pay' => 'Receivable',
                        'payment_status' => $payment_status,
                        'payment_nth' => $payment_nth,
                        'user_id' => auth()->user()->id,
                        'warehouse_id' => auth()->user()->warehouse_id
                    ]);
            });

            return redirect('/piutang/' . $rcv->contact_id . '/detail')->with('success', 'Receivable updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $rcv = Receivable::find($id);
        $invoice = Receivable::where('invoice', $rcv->invoice)->get();

        $account_trace = AccountTrace::where([
            ['invoice', $rcv->invoice],
            ['payment_nth', $rcv->payment_nth]
        ])->get();

        if ($rcv->bill_amount > 0 && $invoice->count() > 1) {
            return redirect()->back()->with('error', 'Receivable has been paid');
        }

        // Check if records exist before attempting deletion
        if ($rcv) {
            $rcv->delete();
        }

        if ($account_trace->isNotEmpty()) {
            // Delete each account_trace individually
            foreach ($account_trace as $trace) {
                $trace->delete();
            }
        }

        // After deletion logic
        if (!$rcv) {
            return redirect('/piutang')->with('success', 'Receivable deleted successfully');
        }

        if (Receivable::where('contact_id', $rcv->contact_id)->count() == 0) {
            return redirect('/piutang')->with('success', 'Receivable deleted successfully');
        } else {
            return redirect('/piutang/' . $rcv->contact_id . '/detail')->with('success', 'Receivable deleted successfully');
        }
    }
}
