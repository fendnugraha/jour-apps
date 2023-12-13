@extends('include.main')
   
   @section('container')
   <span class="fs-5 fw-semibold">Dashboard</span>
   <hr>
    <!-- Main Content -->
<div class="dashboard-area">
    <div class="card dashboard-area-assets">
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 style="font-weight: 700;">Assets</h5>
            <div class="account-value">
                <h2><i class="fa-solid fa-vault"></i></h2>
                <span class="float-end"><?= custom_number(18000000000);?></span>
            </div>
        </div>
    </div>
    <div class="card dashboard-area-liabilities">
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 style="font-weight: 700;">Liabilities</h5>
            <div class="account-value">
                <h2><i class="fa-solid fa-file-invoice"></i></h2>
                <span class="float-end">1.600.000.000</span>
            </div>
        </div>
    </div>
    <div class="card dashboard-area-equity">
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 style="font-weight: 700;">Equity</h5>
            <div class="account-value">
                <h2><i class="fa-solid fa-briefcase"></i></h2>
                <span class="float-end">1.600.000.000</span>
            </div>
        </div>
    </div>
    <div class="card dashboard-area-kas">
        <div class="card-body d-flex flex-column justify-content-between">
            <h5 style="font-weight: 700;">Overall Balance</h5>
            <div class="account-value">
                <span class="float-end"><sup><i class="fa-solid fa-wallet"></i> </sup> 1.600.000.000</span>
            </div>
            <div class="card-cash-list">
                <div class="card-cash-list-items mb-2 d-flex justify-content-between align-items-center">
                    <span class="text-muted">Total in Cash</span>
                    <span>1.600.000.000</span>
                </div>
                <div class="card-cash-list-items d-flex justify-content-between align-items-center">
                    <span class="text-muted">Total in Bank</span>
                    <span>1.600.000.000</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card dashboard-area-piutang">
        <div class="card-body d-flex flex-column justify-content-evenly">
            <h2><i class="fa-solid fa-file-invoice-dollar"></i></h2>
            <h3 class="text-end font-weight-bold">1.600.000.000</h3>
            <h5>Piutang</h5>
        </div>
    </div>
    <div class="card dashboard-area-hutang">
        <div class="card-body d-flex flex-column justify-content-evenly">
            <h2><i class="fa-solid fa-credit-card"></i></h2>
            <h3 class="text-end font-weight-bold">1.600.000.000</h3>
            <h5>Hutang</h5>
        </div>
    </div>
    <div class="card dashboard-area-revenue">
        <div class="card-body">
            <h5 style="font-weight: 700;">Pendapatan</h5>
            <h2><i class="fa-solid fa-cash-register"></i></h2>
            <h4 class="float-end">1.600.000.000</h4>
        </div>
    </div>
    <div class="card dashboard-area-hpp">
        <div class="card-body">
            <h5 style="font-weight: 700;">Hpp</h5>
            <h2><i class="fa-solid fa-money-bills"></i></h2>
            <h4 class="float-end">1.600.000.000</h4>
        </div>
    </div>
    <div class="card dashboard-area-profit">
        <div class="card-body">
            <h5 style="font-weight: 700;">Net Profit</h5>
            <h2><i class="fa-solid fa-sack-dollar"></i></h2>
            <h4 class="float-end">1.600.000.000</h4>
        </div>
    </div>
    <div class="card dashboard-area-expense">
        <div class="card-body">
            <h5 style="font-weight: 700;">Pengeluaran</h5>
            <h2><i class="fa-solid fa-tags"></i></h2>
            <h4 class="float-end">1.600.000.000</h4>
        </div>
    </div>
    <div class="card dashboard-area-finance">
        <div class="card-body overflow-auto">
            <div class="card-finance-indicator">
                <div class="card-finance-indicator-icon">
                    <small><i class="fa-solid fa-file-invoice"></i></small>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Debt Ratio</h5>
                    <span>
                        12%</span>
                </div>
            </div>
            <div class="card-finance-indicator">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-coins"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Current Ratio</h5>
                    <span>
                        12%</span>
                </div>
            </div>
            <div class="card-finance-indicator">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-money-bills"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Quick Ratio</h5>
                    <span>
                        12%</span>
                </div>
            </div>
            <div class="card-finance-indicator">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-money-check-dollar"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Debt to Equity Ratio</h5>
                    <span>
                        12%</span>
                </div>
            </div>
            <div class="card-finance-indicator">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-gem"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Return on Equity Ratio</h5>
                    <span>
                        12%</span>
                </div>
            </div>
            <div class="card-finance-indicator">
                <div class="card-finance-indicator-icon">
                    <span><i class="fa-solid fa-coins"></i></span>
                </div>
                <div class="card-finance-indicator-content">
                    <h5>Net Profit Margin Ratio</h5>
                    <span>
                        12%</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Content -->
   @endsection
