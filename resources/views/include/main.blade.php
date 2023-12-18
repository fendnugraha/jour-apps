<!doctype html>
<html lang="en" data-bs-theme="auto">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Jour Apps - {{ $title }}</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="/assets/img/favicon/site.webmanifest">
        <link rel="mask-icon" href="/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/jquery-ui.css">
        <!-- <link rel="stylesheet" href="/assets/css/datatables.min.css"> -->
        <link rel="stylesheet" href="/assets/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="/assets/css/all.min.css">
        <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
        <!-- <link rel="stylesheet" href="/assets/css/dataTables.jqueryui.min.css"> -->
        <!-- <link rel="stylesheet" href="/assets/css/jquery.dataTables.min.css"> -->
        <link href="/assets/css/sidebars.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/mycss.css">
    </head>
  <body>

<main class="d-flex flex-nowrap">

  <div class="flex-shrink-0 p-3" style="width: 280px;">
    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
      <span class="fs-5 fw-semibold">DOA IBU Inc.</span>
    </a>
    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
          Home
        </button>
        <div class="collapse show" id="home-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Updates</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Reports</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          Dashboard
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="/home" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Overview</a></li>
            <li><a href="/home/jurnal" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Jurnal</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Monthly</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Annually</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          Orders
        </button>
        <div class="collapse" id="orders-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">New</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Processed</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Shipped</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Returned</a></li>
          </ul>
        </div>
      </li>
      <li class="border-top my-3"></li>
      <li class="mb-1">
        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
          Account
        </button>
        <div class="collapse" id="account-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">New...</a></li>
            <li><a href="#" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Profile</a></li>
            <li><a href="/setting" class="link-body-emphasis d-inline-flex text-decoration-none rounded">Settings</a></li>
            <li><form action="/auth/logout" method="post">
            @csrf
            <button type="submit" class="link-body-emphasis d-inline-flex rounded" style="background-color: transparent;
                background-repeat: no-repeat;
                border: none;">Sign out</button></form></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
  <div class="container overflow-auto p-3">
    <div class="breadchrumb-area mb-3">
      <h4>{{ $title }}</h4>
    </div>
    
    @yield('container')
    
  
  </div>
</main>
    


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
    <script src="/assets/js/sidebars.js"></script>
    <script src="/assets/js/myjs.js"></script>
</body>

    
</html>
