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
        <link rel="stylesheet" href="/assets/css/mycss.css">
        {{-- @vite('resources/css/app.css') --}}
    </head>
  <body>
    <div class="d-flex vh-100">

    @yield('container') 
    
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
      @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
      
      @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif
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
    <script src="/assets/js/sidebars.js"></script>
    <script src="/assets/js/myjs.js"></script>
</body>

    
</html>
