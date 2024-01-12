@extends('include.main')

@section('container')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Saldo awal</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> {{ number_format(intval($initBalance)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Debet</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> {{ number_format(intval($debt_total->total)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Kredit</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> {{ number_format(intval($cred_total->total)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Saldo akhir</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> {{ number_format(intval($endBalance)) }}</h3>
            </div>
        </div>
    </div>
</div>

<form action="/report/general-ledger" method="post" class="form-inline my-3">
    @csrf
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="accounts">Akun</label>
                <select name="accounts" id="accounts" class="form-select">
                    <option value="">Pilih Akun</option>
                    @foreach ($account as $ac)
                        <option value="{{ $ac->acc_code }}" {{$accounts == $ac->acc_code ? 'selected' : ''}}>{{ $ac->acc_code }} - {{ $ac->acc_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="start_date">Dari</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $start_date }}">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="end_date">Sampai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $end_date }}">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary my-2">Submit</button>
    <a href="/report" class="btn btn-secondary my-2">Kembali</a>

    <a href="/report/general-ledger/print" class="btn btn-success my-2"><i class="fa-solid fa-print"></i> Cetak</a>
</form>


<table class="table display-no-order">
<thead>
<tr>
    <th>WAKTU</th>
    <th>INVOICE</th>
    <th>DESKRIPSI</th>
    <th>DEBET</th>
    <th>CREDIT</th>
    <th>SALDO</th>
</tr>
</thead>
<tbody>
    <?php $balance = 0; ?>
    @foreach ($account_trace as $ac)
    <?php
    $debt_amount = $ac->debt_code == $accounts ? $ac->amount : 0;
    $cred_amount = $ac->cred_code == $accounts ? $ac->amount : 0;
    $balance += $debt_amount - $cred_amount;
    ?>
    <tr>
        <td>{{ $ac->date_issued }}</td>
        <td>{{ $ac->invoice }}</td>
        <td>
            <span class="badge text-bg-success">{{ $ac->debt->acc_name ?? ''}} x {{ $ac->cred->acc_name ?? ''}}</span>
            <span class="badge text-bg-warning">{{ $ac->warehouse->w_name}}</span>
            <span class="badge text-bg-dark">{{ $ac->user->name}}</span>
            <br>
            #{{ $ac->id }}. {{ $ac->description }}
        </td>
        <td>{{ $ac->debt_code == $accounts ? number_format($ac->amount) : '' }}</td>
        <td>{{ $ac->cred_code == $accounts ? number_format($ac->amount) : '' }}</td>
        <td>{{ number_format($balance) }}</td>
    </tr>
    @endforeach
</tbody>
</table>
@endsection