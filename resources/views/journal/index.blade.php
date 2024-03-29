@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')
        <main class="content">
        <!-- Content  -->
        
        <div class="content-menu d-flex gap-2 w-100">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle px-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Add New
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/jurnal/addjournal">Jurnal Umum</a></li>
                  <li><a class="dropdown-item" href="/jurnal/adddeposit">Deposit</a></li>
                  <li><a class="dropdown-item" href="/jurnal/addSalesValues">Penjualan (Value)</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle px-5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Finance
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="/piutang">Piutang</a></li>
                  <li><a class="dropdown-item" href="/hutang">Hutang</a></li>
                </ul>
            </div>
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cashBank">Cash & Bank</a>
            <div class="search-form flex-grow-1">
                <form action="{{ route('jurnal.index') }}" method="GET" class="">
                    {{-- @csrf --}}
                    <div class="input-group">
                    <input type="text" class="form-control" name="query" placeholder="Search invoice .." value="{{ $query }}">
                    <button type="submit" class="btn btn-primary "><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
<div class="modal fade" id="cashBank" tabindex="-1" aria-labelledby="cashBankLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="cashBankLabel">Filter Balance Sheets (Neraca)</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/report/cash-bank" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label for="end_date">Sampai</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
      </div>
    </div>
  </div>


        
        <table class="table">
            <thead>
                <tr>
                    <th>DESKRIPSI</th>
                    <th>JUMLAH</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accountTrace as $acctrace)                   
                
                <tr>
                    <td>
                        <span class="badge text-bg-success">{{ $acctrace->debt->acc_name ?? ''}} x {{ $acctrace->cred->acc_name ?? ''}}</span>
                        <span class="badge text-bg-warning">{{ $acctrace->warehouse->w_name}}</span>
                        <span class="badge text-bg-dark">{{ $acctrace->user->name}}</span>
                        <br>
                        <small>#{{ $acctrace->id }} | {{ $acctrace->date_issued }} | {{ $acctrace->invoice }}</small>
                        <br>
                        Note: {{ $acctrace->description }}. {{$acctrace->receivable->first()->contact->name  ?? ''}} {{$acctrace->payable->first()->contact->name  ?? ''}}
                    </td>
                    <td class="text-end">{{ number_format($acctrace->amount) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $acctrace->status == 1 ? 'text-bg-success' : 'text-bg-danger' }}">
                        {{ $acctrace->status == 1 ? 'Success' : 'Void' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="action-buttons" {{ $acctrace->rcv_pay !== null ? 'hidden' : '' }}>
                        <a href="/jurnal/{{ $acctrace->id }}/detail" class="btn btn-primary btn-sm">
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
                    </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$accountTrace->links() }}
    </main>
        <!-- End Content -->
    </div>


@endsection