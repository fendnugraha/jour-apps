@extends('include.main')

@section('container')
<div class="content-menu d-flex gap-2">
    <div class="dropdown mb-2">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Add New
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="/jurnal/addjournal">Jurnal</a></li>
          <li><a class="dropdown-item" href="/jurnal/adddeposit">Deposit</a></li>
          <li><a class="dropdown-item" href="#">Penjualan (Value)</a></li>
        </ul>
    </div>
    <div class="dropdown mb-2">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Finance
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="/piutang">Piutang</a></li>
          <li><a class="dropdown-item" href="/hutang">Hutang</a></li>
        </ul>
    </div>
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
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accountTrace as $acctrace)
                    
                
                <tr>
                    <td>{{ $acctrace->waktu }}</td>
                    <td>{{ $acctrace->invoice }}</td>
                    <td>
                        <span class="badge bg-success">{{ $acctrace->debt->acc_name ?? ''}} x {{ $acctrace->cred->acc_name ?? ''}}</span>
                        <span class="badge bg-warning">{{ $acctrace->warehouse->w_name}}</span>
                        <span class="badge bg-warning">{{ $acctrace->user->name}}</span>
                        <br>
                        #{{ $acctrace->id }}. {{ $acctrace->description }}
                    </td>
                    <td>{{ number_format($acctrace->jumlah) }}</td>
                    <td>
                        <span class="badge {{ $acctrace->status == 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $acctrace->status == 1 ? 'Success' : 'Void' }}
                        </span>
                    </td>
                    <td>
                        <a href="/jurnal/{{ $acctrace->id }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="/jurnal/{{ $acctrace->id }}/edit" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="/jurnal/{{ $acctrace->id }}/delete" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                        
                            <!-- Your form fields or button here -->
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>



@endsection