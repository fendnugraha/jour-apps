@extends('include.main')

@section('container')
<div class="dropdown mb-2">
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      Add New
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="/home/addjournal">Jurnal</a></li>
      <li><a class="dropdown-item" href="#">Deposit</a></li>
      <li><a class="dropdown-item" href="#">Penjualan (Value)</a></li>
    </ul>
  </div>
<div class="card">
    <div class="card-body">
        <table class="table display">
            <thead>
                <tr>
                    <th>WAKTU</th>
                    <th>INVOICE</th>
                    <th>DESKRIPSI</th>
                    <th>JUMLAH</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accountTrace as $acctrace)
                    
                
                <tr>
                    <td>{{ $acctrace->waktu }}</td>
                    <td>{{ $acctrace->invoice }}</td>
                    <td>{{ $acctrace->description }} {{ $acctrace->debt_code}} User: {{ $acctrace->user->name}}</td>
                    <td>{{ $acctrace->jumlah }}</td>
                    <td>{{ $acctrace->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection