@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">


        <!-- Content  -->
        <div class="setting-icon d-flex justify-content-between flex-wrap gap-3">
            <a href="#" class="setting-icon-action" data-bs-toggle="modal" data-bs-target="#cashFlow">
                <h1><i class="fa-solid fa-sliders"></i></h1> <span class="setting-icon-text">Cashflow</span>
            </a>
            <a href="#" class="setting-icon-action" data-bs-toggle="modal" data-bs-target="#balanceSheet">
                <h1><i class="fa-solid fa-scale-balanced"></i></h1> <span class="setting-icon-text"> Neraca</span>
            </a>
            <a href="#" class="setting-icon-action" data-bs-toggle="modal" data-bs-target="#profitLoss">
                <h1><i class="fa-solid fa-coins"></i></h1> <span class="setting-icon-text"> Laba Rugi</span>
            </a>
            <a href="#" class="setting-icon-action" data-bs-toggle="modal" data-bs-target="#generalLedger">
                <h1><i class="fa-solid fa-book"></i></h1> <span class="setting-icon-text"> Buku Besar</span>
            </a>
            <a href="#" class="setting-icon-action" data-bs-toggle="modal" data-bs-target="#dailyProfit">
                <h1><i class="fa-solid fa-cash-register"></i></h1> <span class="setting-icon-text"> Daily Profit</span>
            </a>
            <!-- <a href="#" class="setting-icon-action">
                <h1><i class="fa-solid fa-users-line"></i></h1> <span class="setting-icon-text"> Employes</span>
            </a> -->
        </div>
        

<!-- Modal -->
<div class="modal fade" id="dailyProfit" tabindex="-1" aria-labelledby="dailyProfitLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="dailyProfitLabel">Daily Profit</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/report/daily-profit" method="post">
                @csrf
                <div class="mb-3">
                    <label for="month" class="form-label">Select Month:</label>
                    <select name="month" id="month" class="form-select">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>
                </div>
        
                <div class="mb-3">
                    <label for="year" class="form-label">Select Year:</label>
                    <select name="year" id="year" class="form-select">
                        @php
                            $currentYear = date('Y');
                            $startYear = 2020; // Change this to your desired start year
                        @endphp
                        @for ($i = $currentYear; $i >= $startYear; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="generalLedger" tabindex="-1" aria-labelledby="generalLedgerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="generalLedgerLabel">Filter General ledger (Buku Besar)</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/report/general-ledger" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label for="accounts">Akun</label>
                    <select name="accounts" id="accounts" class="form-select">
                        <option value="">Pilih Akun</option>
                        @foreach ($account as $ac)
                            <option value="{{ $ac->acc_code }}">{{ $ac->acc_code }} - {{ $ac->acc_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="start_date">Dari</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
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

  <!-- Modal -->
<div class="modal fade" id="cashFlow" tabindex="-1" aria-labelledby="cashFlowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="cashFlowLabel">Filter Cashflow (Aruskas)</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/report/cashflow" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label for="start_date">Dari</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
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

  <!-- Modal -->
<div class="modal fade" id="balanceSheet" tabindex="-1" aria-labelledby="balanceSheetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="balanceSheetLabel">Filter Balance Sheets (Neraca)</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/report/balance-sheet" method="post">
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

<!-- Modal -->
<div class="modal fade" id="profitLoss" tabindex="-1" aria-labelledby="profitLossLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="profitLossLabel">Filter General ledger (Buku Besar)</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/report/profit-loss" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label for="start_date">Dari</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
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
  {{-- ================================================= --}}


        </main>
@endsection 