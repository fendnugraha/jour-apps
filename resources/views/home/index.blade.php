@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Doa Ibu Warehouse | Homepage</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="" width="30"
                                    height="30">
                                fendnugraha92
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Setting</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content  -->
        <main class="content">
            <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                </ol>
            </nav>

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
                            <span class="float-end"><?= custom_number(18000000000);?></span>
                        </div>
                    </div>
                </div>
                <div class="card dashboard-area-equity">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 style="font-weight: 700;">Equity</h5>
                        <div class="account-value">
                            <h2><i class="fa-solid fa-briefcase"></i></h2>
                            <span class="float-end"><?= custom_number(18000000000);?></span>
                        </div>
                    </div>
                </div>
                <div class="card dashboard-area-kas">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 style="font-weight: 700;">Overall Balance</h5>
                        <div class="account-value">
                            <span class="float-end"><sup><i class="fa-solid fa-wallet"></i> </sup> <?= custom_number(18000000000);?></span>
                        </div>
                        <div class="card-cash-list">
                            <div class="card-cash-list-items mb-2 d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total in Cash</span>
                                <span><?= custom_number(18000000000);?></span>
                            </div>
                            <div class="card-cash-list-items d-flex justify-content-between align-items-center">
                                <span class="text-muted">Total in Bank</span>
                                <span><?= custom_number(18000000000);?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card dashboard-area-piutang">
                    <div class="card-body d-flex flex-column justify-content-evenly">
                        <h2><i class="fa-solid fa-file-invoice-dollar"></i></h2>
                        <h3 class="text-end font-weight-bold"><?= custom_number(18000000000);?></h3>
                        <h5>Piutang</h5>
                    </div>
                </div>
                <div class="card dashboard-area-hutang">
                    <div class="card-body d-flex flex-column justify-content-evenly">
                        <h2><i class="fa-solid fa-credit-card"></i></h2>
                        <h3 class="text-end font-weight-bold"><?= custom_number(18000000000);?></h3>
                        <h5>Hutang</h5>
                    </div>
                </div>
                <div class="card dashboard-area-revenue">
                    <div class="card-body">
                        <h5 style="font-weight: 700;">Pendapatan</h5>
                        <h2><i class="fa-solid fa-cash-register"></i></h2>
                        <h4 class="float-end"><?= custom_number(18000000000);?></h4>
                    </div>
                </div>
                <div class="card dashboard-area-hpp">
                    <div class="card-body">
                        <h5 style="font-weight: 700;">Hpp</h5>
                        <h2><i class="fa-solid fa-money-bills"></i></h2>
                        <h4 class="float-end"><?= custom_number(18000000000);?></h4>
                    </div>
                </div>
                <div class="card dashboard-area-profit">
                    <div class="card-body">
                        <h5 style="font-weight: 700;">Net Profit</h5>
                        <h2><i class="fa-solid fa-sack-dollar"></i></h2>
                        <h4 class="float-end"><?= custom_number(18000000000);?></h4>
                    </div>
                </div>
                <div class="card dashboard-area-expense">
                    <div class="card-body">
                        <h5 style="font-weight: 700;">Pengeluaran</h5>
                        <h2><i class="fa-solid fa-tags"></i></h2>
                        <h4 class="float-end"><?= custom_number(18000000000);?></h4>
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
        </main>
        <!-- End Content -->
    </div>


@endsection