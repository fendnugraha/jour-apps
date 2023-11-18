<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jour Apps - {{ $title }}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/assets/css/datatables.min.css"> -->
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
    <!-- <link rel="stylesheet" href="/assets/css/dataTables.jqueryui.min.css"> -->
    <!-- <link rel="stylesheet" href="/assets/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="/assets/css/mycss.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">DOA IBU</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= url('home'); ?> "><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="# ">Dashboard</a>
                    </li> -->
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Transaksi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= url('purchase'); ?>">Pembelian</a></li>
                            <li><a class="dropdown-item" href="<?= url('sales'); ?>">Penjualan</a></li>
                        </ul>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('finance/jurnal'); ?>"><i class="fa-solid fa-book"></i> Jurnal</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-money-bill-transfer"></i> Hutang Piutang
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= url('finance/payable'); ?>">Hutang</a></li>
                            <li><a class="dropdown-item" href="<?= url('finance/receivable'); ?>">Piutang</a></li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?= url('report'); ?>">Report</a>
                    </li> -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-clipboard-list"></i> Report
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= url('report/cashflow'); ?>">Cashflow</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= url('report/neraca'); ?>">Neraca Lajur</a></li>
                            <li><a class="dropdown-item" href="<?= url('report/neracaMonthly'); ?>">Neraca Bulanan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= url('report/profitLossStatementDaily'); ?>">Daily Profit</a></li>
                            <li><a class="dropdown-item" href="<?= url('report/profitLossStatement'); ?>">Laba Rugi</a></li>
                            <li><a class="dropdown-item" href="<?= url('report/profitLossStatementMonthly'); ?>">Laba Rugi Bulanan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= url('report/generalLedger'); ?>">Buku Besar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('setting'); ?>"><i class="fa-solid fa-screwdriver-wrench"></i> Setting</a>
                    </li>
                    <li class="nav-item">
                        {{-- <a class="nav-link text-warning active" href="#"><i class="fa-solid fa-masks-theater"></i> <strong>{{ auth()->user()-name }}</strong></a> --}}
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <form action="/auth/logout" method="post">
                    <button type="submit" class="nav-link"></button>
                </form>
            </div>
        </div>

    </nav>
    <div class="container mt-0">
        <div class="card card-page-title">
            <p>{{ $title }}</p>
        </div>
    </div>
    <div class="container mt-3">

        @yield('container')


    </div>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="/assets/js/bootstrap.js"></script> -->
    <!-- <script src="/assets/js/datatables.min.js"></script> -->
    <!-- <script src="/assets/js/popper.min.js"></script> -->
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/js/jquery-ui.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/js/all.min.js"></script>
    <script src="/assets/js/fontawesome.min.js"></script>
    <script src="/assets/js/myjs.js"></script>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable();
            $('table.display-noorder').DataTable({
                "ordering": false,
                // "paging": false
            });
        });

        $(function() {
            $(".datepicker").datepicker({
                dateFormat: 'yy/mm/dd',
                showOtherMonths: true,
                selectOtherMonths: true
            }).val();
        });
    </script>
</body>

</html>