<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Payable;
use App\Models\AccountTrace;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;

class PayableController extends Controller
{

    public function index()
    {
        $bill_total = Payable::select(
            DB::raw('payables.contact_id, SUM(bill_amount) as bill, SUM(payment_amount) as payment, SUM(bill_amount - payment_amount) as balance')
        )
            ->join('contacts', 'contacts.id', '=', 'payables.contact_id')
            ->groupBy('payables.contact_id')
            ->get();

        return view('journal.payable.index', [
            'title' => 'Hutang',
            'bill_total' => $bill_total
        ]);
    }

    public function invoice($id)
    {
        $contact = Payable::find($id)->contact;
        $payable = Payable::find($id);
        $payable->invoice = $this->invoice_payable($contact->id);
        $payable->save();
        return redirect('/hutang/' . $id . '/invoice');
    }

    public function create()
    {
        return view('journal.payable.create', [
            'title' => 'Form Tambah Hutang',
            'contacts' => Contact::all(),
            'account' => ChartOfAccount::where('account_id', 19)->get(),
            'rscFund' => ChartOfAccount::whereIn('account_id', [1, 2, 6])->get()
        ]);
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
            $pay = new Payable();
            $invoice_number = $pay->invoice_payable($request->contact);

            DB::transaction(function () use ($request, $invoice_number, $dateIssued) {
                Payable::create([
                    'date_issued' => $dateIssued,
                    'due_date' => $dateIssued->copy()->addDays(30),
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'bill_amount' => $request->amount,
                    'payment_amount' => 0,
                    'payment_status' => 0,
                    'payment_nth' => 0,
                    'contact_id' => $request->contact,
                    'account_code' => $request->cred_code
                ]);

                AccountTrace::create([
                    'date_issued' => $dateIssued,
                    'invoice' => $invoice_number,
                    'description' => $request->description,
                    'debt_code' => $request->debt_code,
                    'cred_code' => $request->cred_code,
                    'amount' => $request->amount,
                    'status' => 1,
                    'rcv_pay' => 'Payable',
                    'payment_status' => 0,
                    'payment_nth' => 0,
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => auth()->user()->warehouse_id
                ]);
            });

            return redirect('/hutang')->with('success', 'Hutang berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function detail($id)
    {
        $pybs = Payable::select(
            'contact_id',
            DB::raw('SUM(bill_amount) as bill'),
            DB::raw('SUM(payment_amount) as payment'),
            DB::raw('SUM(bill_amount - payment_amount) as balance')
        )
            ->where('contact_id', $id)
            ->groupBy('contact_id')
            ->first();

        $pyb = Payable::select('Payables.*')
            ->join('chart_of_accounts', 'Payables.account_code', '=', 'chart_of_accounts.acc_code')
            ->where('Payables.contact_id', $id)
            ->orderBy('Payables.date_issued', 'desc')
            ->get();

        $invoices = $pyb->pluck('invoice')->toArray();
        $balances = Payable::selectRaw('invoice, SUM(bill_amount) - SUM(payment_amount) AS balance')
            ->whereIn('invoice', $invoices)
            ->groupBy('invoice')
            ->pluck('balance', 'invoice');

        $rscFund = ChartOfAccount::whereIn('account_id', [1, 2, 6, 19, 26])->get();

        if (!$pybs) {
            return redirect()->back()->with('error', 'Payable not found');
        }
        return view('journal.payable.detail', [
            'title' => 'Detail Hutang',
            'pyb' => $pyb,
            'pybs' => $pybs,
            'invoices' => $invoices,
            'balances' => $balances,
            'rscFund' => $rscFund
        ]);
    }

    public function edit($id)
    {
        $pyb = Payable::find($id);
        if (!$pyb) {
            return redirect()->back()->with('error', 'Payable not found');
        }
        return view('journal.payable.edit', [
            'title' => 'Edit Hutang',
            'pyb' => $pyb,
            'contacts' => Contact::all(),
            'account' => ChartOfAccount::where('account_id', 19)->get(),
            'rscFund' => ChartOfAccount::whereIn('account_id', [1, 2, 6])->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_issued' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required|max:160',
            'contact' => 'required',
            'debt_code' => 'required',
            'cred_code' => 'required',
        ]);
    }

    public function payment(Request $request)
    {
        $rcv = Payable::selectRaw('SUM(bill_amount) - SUM(payment_amount) AS balance')
            ->where('invoice', $request->invoice)
            ->groupBy('invoice')
            ->first();

        $dtRcv = Payable::where([
            ['invoice', $request->invoice],
            ['payment_nth', 0],
        ])->first();

        $request->validate([
            'date_issued' => 'required',
            'amount' => 'required|numeric|max:' . ($rcv->balance ?? 0),
            'description' => 'required|max:160',
            'invoice' => 'required',
            'cred_code' => 'required',
        ]);

        // \dd($request->all());

        try {

            $dateIssued = Carbon::parse($request->date_issued);
            $payment_status = $rcv->balance - $request->amount == 0 ? 1 : 0;
            $payment_nth = Payable::selectRaw('MAX(payment_nth) as nth')->where('invoice', $request->invoice)->first('nth')->nth + 1;

            DB::transaction(function () use ($request, $dateIssued, $payment_status, $payment_nth, $dtRcv) {
                Payable::create([
                    'date_issued' => $dateIssued,
                    'due_date' => $dtRcv->due_date,
                    'invoice' => $request->invoice,
                    'description' => $request->description,
                    'bill_amount' => 0,
                    'payment_amount' => $request->amount,
                    'payment_status' => $payment_status,
                    'payment_nth' => $payment_nth,
                    'contact_id' => $dtRcv->contact_id,
                    'account_code' => $request->cred_code
                ]);

                AccountTrace::create([
                    'date_issued' => $dateIssued,
                    'invoice' => $request->invoice,
                    'description' => $request->description,
                    'debt_code' => $dtRcv->account_code,
                    'cred_code' => $request->cred_code,
                    'amount' => $request->amount,
                    'status' => 1,
                    'rcv_pay' => 'Payable',
                    'payment_status' => $payment_status,
                    'payment_nth' => $payment_nth,
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => auth()->user()->warehouse_id
                ]);
            });

            return redirect('/hutang/' . $dtRcv->contact_id . '/detail')->with('success', 'Payment success');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $rcv = Payable::find($id);
        $invoice = Payable::where('invoice', $rcv->invoice)->get();

        $account_trace = AccountTrace::where([
            ['invoice', $rcv->invoice],
            ['payment_nth', $rcv->payment_nth]
        ])->get();

        if ($rcv->bill_amount > 0 && $invoice->count() > 1) {
            return redirect()->back()->with('error', 'Payable has been paid');
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
            return redirect('/hutang')->with('success', 'Payable deleted successfully');
        }

        if (Payable::where('contact_id', $rcv->contact_id)->count() == 0) {
            return redirect('/hutang')->with('success', 'Payable deleted successfully');
        } else {
            return redirect('/hutang/' . $rcv->contact_id . '/detail')->with('success', 'Payable deleted successfully');
        }
    }
}
