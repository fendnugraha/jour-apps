@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">


        <!-- Content  -->
        <div class="dashboard-area">
            <div class="card card-widget dashboard-area-assets">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 style="font-weight: 700;">Assets</h5>
                    <div class="account-value">
                        <h2><i class="fa-solid fa-vault"></i></h2>
                        <span class="float-end">{{ custom_number(intval($assets->flatten()->sum('balance'))) }}</span>
                    </div>
                </div>
            </div>
            <div class="card card-widget dashboard-area-liabilities">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 style="font-weight: 700;">Liabilities</h5>
                    <div class="account-value">
                        <h2><i class="fa-solid fa-file-invoice"></i></h2>
                        <span class="float-end">{{ custom_number(intval($liabilities->flatten()->sum('balance'))) }}</span>
                    </div>
                </div>
            </div>
            <div class="card card-widget dashboard-area-equity">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 style="font-weight: 700;">Equity</h5>
                    <div class="account-value">
                        <h2><i class="fa-solid fa-briefcase"></i></h2>
                        <span class="float-end">{{ custom_number(intval($equity->flatten()->sum('balance'))) }}</span>
                    </div>
                </div>
            </div>
            <div class="card card-widget dashboard-area-kas">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 style="font-weight: 700;">Overall Balance</h5>
                    <div class="account-value">
                        <span class="float-end"><sup><i class="fa-solid fa-wallet"></i> </sup> {{ custom_number($totalCash) }}</span>
                    </div>
                    <div class="card-cash-list">
                        <div class="card-cash-list-items mb-2 d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total in Cash</span>
                            <span>{{ custom_number(intval($cash->flatten()->sum('balance'))) }}</span>
                        </div>
                        <div class="card-cash-list-items d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total in Bank</span>
                            <span>{{ custom_number(intval($bank->flatten()->sum('balance'))) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-widget dashboard-area-piutang">
                <div class="card-body d-flex flex-column justify-content-evenly">
                    <h2><i class="fa-solid fa-file-invoice-dollar"></i></h2>
                    <h3 class="text-end font-weight-bold">{{ custom_number(intval($receivable->flatten()->sum('balance'))) }}</h3>
                    <h5>Piutang</h5>
                </div>
            </div>
            <div class="card card-widget dashboard-area-hutang">
                <div class="card-body d-flex flex-column justify-content-evenly">
                    <h2><i class="fa-solid fa-credit-card"></i></h2>
                    <h3 class="text-end font-weight-bold">{{ custom_number(intval($payable->flatten()->sum('balance'))) }}</h3>
                    <h5>Hutang</h5>
                </div>
            </div>
            <div class="card card-widget dashboard-area-revenue">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Pendapatan</h5>
                    <h2><i class="fa-solid fa-cash-register"></i></h2>
                    <h4 class="float-end">{{ custom_number(intval($revenue->flatten()->sum('balance'))) }}</h4>
                </div>
            </div>
            <div class="card card-widget dashboard-area-hpp">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Hpp</h5>
                    <h2><i class="fa-solid fa-money-bills"></i></h2>
                    <h4 class="float-end">{{ custom_number(intval($cost->flatten()->sum('balance'))) }}</h4>
                </div>
            </div>
            <div class="card card-widget dashboard-area-profit">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Net Profit</h5>
                    <h2><i class="fa-solid fa-sack-dollar"></i></h2>
                    <h4 class="float-end">{{ custom_number($netProfit) }}</h4>
                </div>
            </div>
            <div class="card card-widget dashboard-area-expense">
                <div class="card-body">
                    <h5 style="font-weight: 700;">Pengeluaran</h5>
                    <h2><i class="fa-solid fa-tags"></i></h2>
                    <h4 class="float-end">{{ custom_number(intval($expense->flatten()->sum('balance'))) }}</h4>
                </div>
            </div>
            <div class="card card-widget dashboard-area-finance">
                <div class="card-body overflow-auto">
                    <div class="card-finance-indicator">
                        <div class="card-finance-indicator-icon">
                            <small><i class="fa-solid fa-file-invoice"></i></small>
                        </div>
                        <div class="card-finance-indicator-content">
                            <h5>Debt Ratio</h5>
                            <span>
                                {{ $debtRatio }}%</span>
                        </div>
                    </div>
                    <div class="card-finance-indicator">
                        <div class="card-finance-indicator-icon">
                            <span><i class="fa-solid fa-coins"></i></span>
                        </div>
                        <div class="card-finance-indicator-content">
                            <h5>Current Ratio</h5>
                            <span>
                                {{ $currentRatio }}%</span>
                        </div>
                    </div>
                    <div class="card-finance-indicator">
                        <div class="card-finance-indicator-icon">
                            <span><i class="fa-solid fa-money-bills"></i></span>
                        </div>
                        <div class="card-finance-indicator-content">
                            <h5>Quick Ratio</h5>
                            <span>
                                {{ $quickRatio }}%</span>
                        </div>
                    </div>
                    <div class="card-finance-indicator">
                        <div class="card-finance-indicator-icon">
                            <span><i class="fa-solid fa-money-check-dollar"></i></span>
                        </div>
                        <div class="card-finance-indicator-content">
                            <h5>Debt to Equity Ratio</h5>
                            <span>
                                {{$debtToEquityRatio}}%</span>
                        </div>
                    </div>
                    <div class="card-finance-indicator">
                        <div class="card-finance-indicator-icon">
                            <span><i class="fa-solid fa-gem"></i></span>
                        </div>
                        <div class="card-finance-indicator-content">
                            <h5>Return on Equity Ratio</h5>
                            <span>
                                {{$returnToEquityRatio}}%</span>
                        </div>
                    </div>
                    <div class="card-finance-indicator">
                        <div class="card-finance-indicator-icon">
                            <span><i class="fa-solid fa-coins"></i></span>
                        </div>
                        <div class="card-finance-indicator-content">
                            <h5>Net Profit Margin Ratio</h5>
                            <span>
                                {{$netProfitMarginRation}}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       


        </main>
@endsection 