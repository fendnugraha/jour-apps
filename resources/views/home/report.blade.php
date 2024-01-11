@extends('include.main')

@section('container')
        <div class="setting-icon d-flex justify-content-between flex-wrap gap-3">
            <a href="/report/cashflow" class="setting-icon-action">
                <h1><i class="fa-solid fa-sliders"></i></h1> <span class="setting-icon-text">Cashflow</span>
            </a>
            <a href="/report/balance-sheet" class="setting-icon-action">
                <h1><i class="fa-solid fa-scale-balanced"></i></h1> <span class="setting-icon-text"> Neraca</span>
            </a>
            <a href="/report/profit-loss" class="setting-icon-action">
                <h1><i class="fa-solid fa-coins"></i></h1> <span class="setting-icon-text"> Laba Rugi</span>
            </a>
            <a href="/report/general-ledger" class="setting-icon-action">
                <h1><i class="fa-solid fa-book"></i></h1> <span class="setting-icon-text"> Buku Besar</span>
            </a>
            <a href="/report/daily-profit" class="setting-icon-action">
                <h1><i class="fa-solid fa-cash-register"></i></h1> <span class="setting-icon-text"> Daily Profit</span>
            </a>
            <!-- <a href="#" class="setting-icon-action">
                <h1><i class="fa-solid fa-users-line"></i></h1> <span class="setting-icon-text"> Employes</span>
            </a> -->
        </div>


@endsection