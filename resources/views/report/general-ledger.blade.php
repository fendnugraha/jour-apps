@extends('include.main')

@section('container')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Saldo awal</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> 100000000</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Debet</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> 100000000</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Kredit</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> 100000000</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4>Saldo akhir</h4>
                <h3><i class="fa-solid fa-file-invoice"></i> 100000000</h3>
            </div>
        </div>
    </div>
</div>

<form action="/report/general-ledger" method="get" class="form-inline my-3">
    @csrf
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="account">Dari</label>
                <select name="account" id="account" class="form-select">
                    <option value="">Pilih Akun</option>
                    @foreach ($account as $ac)
                        <option value="{{ $ac->acc_code }}">{{ $ac->acc_code }} - {{ $ac->acc_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="from">Dari</label>
                <input type="date" name="from" id="from" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="to">Sampai</label>
                <input type="date" name="to" id="to" class="form-control">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary my-2">Submit</button>
    <a href="/report/general-ledger" class="btn btn-secondary my-2">Reset</a>

    <a href="/report/general-ledger/print" class="btn btn-success my-2"><i class="fa-solid fa-print"></i> Cetak</a>
</form>


<table class="table display">
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
    <tr>
        <td>{{ $ac->date_issued }}</td>
        <td>{{ $ac->invoice }}</td>
        <td>{{ $ac->description }}</td>
        <td>{{ $ac->debt_code }}</td>
        <td>{{ $ac->cred_code }}</td>
        <td>{{ $balance += $ac->amount }}</td>
    </tr>
    @endforeach
</tbody>
</table>
@endsection