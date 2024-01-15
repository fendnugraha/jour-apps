@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <div class="row mb-3">
            <div class="col-lg">
                <div class="card text-bg-warning">
                    <div class="card-body">
                        <h3>Invoices</h3>
                        <h1><i class="fa-solid fa-file-invoice"></i> {{ number_format($bill_total->count()) }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card text-bg-warning">
                    <div class="card-body">
                        <h3>Bills</h3>
                        <h1><i class="fa-solid fa-receipt"></i> {{custom_number($bill_total->sum('bill'))}}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card text-bg-secondary">
                    <div class="card-body">
                        <h3>Payments</h3>
                        <h1><i class="fa-solid fa-credit-card"></i> {{custom_number($bill_total->sum('payment'))}}</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-menu-nav d-flex gap-2 mb-3">
            <a href="/jurnal" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Go back</a>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-plus"></i> Add New
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/piutang/addPiutang">Piutang</a></li>
                <li><a class="dropdown-item" href="/piutang/addReceivableDeposit">Piutang Saldo dan Awal</a></li>
                <li><a class="dropdown-item" href="/piutang/addReceivableSales">Piutang Penjualan Barang</a></li>
                </ul>
            </div>
        </div>
        <h4>Receivable Total: {{ number_format($bill_total->sum('balance')) }}</h4>
        <table class="table display-no-order">
        <thead>
        <tr>
            <th>Contact</th>
            <th>Balance</th>
            <th>Status</th>
            <th>Detail</th>
        </tr>
        </thead>
        <tbody>
            
            @foreach ($bill_total as $rv)
            <tr>
                 <td>{{ strtoupper($rv->contact->name) }}</td>
                 <td>{{ number_format($rv->balance) }}</td>
                 <td>
                     <span class="badge {{ $rv->balance == 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                    {{ $rv->balance == 0 ? 'Paid' : 'Unpaid' }}</span>
                </td>
                 <td>
                    <a href="/piutang/{{ $rv->contact->id }}/detail" class="badge text-bg-primary">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                 </td>  
            </tr>
            @endforeach
            
        </tbody>
        </table>
       <!-- End Content -->
    </main>
    </div>


@endsection