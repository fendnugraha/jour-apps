@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <div class="row mb-3">
            <div class="col-lg">
                <div class="card text-bg-dark">
                    <div class="card-body">
                        <h4>Bills</h4>
                        <h1><i class="fa-solid fa-receipt"></i> {{custom_number($pybs->bill)}}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card bg-secondary-subtle">
                    <div class="card-body">
                        <h4>Payments</h4>
                        <h1><i class="fa-solid fa-credit-card"></i> {{custom_number($pybs->payment)}}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg">
                <div class="card text-bg-secondary">
                    <div class="card-body">
                        <h4>Balance</h4>
                        <h1><i class="fa-solid fa-file-invoice"></i> {{custom_number($pybs->balance)}}</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-menu-nav d-flex gap-2 mb-3">
            <a href="/hutang" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Go back</a>
            <a href="/hutang/add" class="btn btn-primary"><i class="fa-solid fa-plus-circle"></i> Add new</a>
            {{-- <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-plus"></i> Add New
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/hutang/add">Hutang</a></li>
                <li><a class="dropdown-item" href="/hutang/addReceivableDeposit">Hutang Saldo & Awal</a></li>
                </ul>
            </div> --}}
            <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#paymentModal">
            <i class="fa-solid fa-credit-card"></i> Input Pembayaran
          </button>
          
          <!-- Modal -->
          <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="paymentModalLabel">Form Pembayaran</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="/hutang/payment" method="POST">
                    @csrf            
                    <!-- Isi form pembayaran di sini -->
                    <div class="mb-3">
                        <label for="date_issued" class="form-label">Date</label>
                        <input type="datetime-local" class="form-control {{ $errors->has('date_issued') ? 'is-invalid' : '' }}" id="date_issued" name="date_issued" placeholder="Masukkan tanggal pembayaran" value="{{ old('date') == null ? date('Y-m-d H:i') : old('date') }}">
                        @error('date_issued')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="invoice" class="form-label">Faktur</label>
                        <select name="invoice" id="invoice" class="form-select {{ $errors->has('invoice') ? 'is-invalid' : '' }}">
                            <option value="">Pilih Faktur</option>
                            @foreach($balances as $invoice => $balance)
                            @if($balance > 0)
                                <option value="{{ $invoice }}" {{ old('invoice') == $invoice ? 'selected' : '' }}>{{ $invoice }} || {{ number_format($balance, 2) }}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('invoice')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="cred_code" class="form-label">Akun Debet</label>
                        <select name="cred_code" id="cred_code" class="form-select {{ $errors->has('cred_code') ? 'is-invalid' : '' }}">
                            <option value="">Pilih Akun Debet</option>
                            @foreach ($rscFund as $ac)
                                <option value="{{ $ac->acc_code }}" {{ old('cred_code') == $ac->acc_code ? 'selected' : '' }}>{{ $ac->acc_code }} - {{ $ac->acc_name }}</option>
                            @endforeach
                        </select>
                        @error('cred_code')
                        <div class="invalid-feedback">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                      <label for="description" class="form-label">Deskripsi</label>
                      <textarea name="description" id="description" cols="30" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" value="{{ old('description') }}">{{ old('description') }}</textarea>
                      @error('description')
                      <div class="invalid-feedback">
                          <small>{{ $message }}</small>
                      </div>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label for="amount" class="form-label">Jumlah Pembayaran</label>
                      <input type="number" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" id="amount" placeholder="Masukkan jumlah pembayaran" value="{{ old('amount') }}">
                      @error('amount')
                      <div class="invalid-feedback">
                          <small>{{ $message }}</small>
                      </div>
                      @enderror
                    </div>
                    <!-- ... -->
                    <button type="submit" class="btn btn-primary">Bayar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <h4>{{ $pybs->contact->name }}. Total: {{ number_format($pybs->balance) }}</h4>
        <table class="display-no-order table">
            <thead>
                <tr>
                    <th>Date Issued</th>
                    <th>Description</th>
                    <th>Bills</th>
                    <th>Payments</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($pyb)
                @php
                    $balance = 0;
                @endphp
        
                @foreach ($pyb as $r)
                <tr>
                    <td>{{ $r->date_issued }}</td>
                    <td>
                        <span class="text-success" style="font-weight: 700">{{ $r->invoice}} | {{ $r->account->acc_name }} | #{{ $r->payment_nth }}</span><br>
                        {{ $r->description }}
                    </td>
                    <td>{{ number_format($r->bill_amount) == 0 ? '' : number_format($r->bill_amount) }}</td>
                    <td>{{ number_format($r->payment_amount) == 0 ? '' : number_format($r->payment_amount) }}</td>
                    <td>
                        <a href="/hutang/{{ $r->id }}/invoice" class="btn btn-primary">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <form action="/hutang/{{ $r->id }}/delete" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
        
                            <!-- Your form fields or button here -->
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger">
                            <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="4">
                    <div class="alert alert-danger" role="alert">
                        No data
                    </div>
                </td>
            </tr>
            @endif
            </tbody>
        </table>
       <!-- End Content -->
    </main>
    </div>


@endsection