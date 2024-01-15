@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <div class="setting-icon">
          <a href="/setting" class="setting-icon-action">
              <h1><i class="fa-solid fa-sliders"></i></h1> <span class="setting-icon-text">General</span>
          </a>
          <a href="/setting/users" class="setting-icon-action">
              <h1><i class="fa-solid fa-users"></i></h1> <span class="setting-icon-text"> Users</span>
          </a>
          <a href="/setting/contacts" class="setting-icon-action">
              <h1><i class="fa-solid fa-address-book"></i></h1> <span class="setting-icon-text"> Contacts</span>
          </a>
          <a href="/setting/accounts" class="setting-icon-action">
              <h1><i class="fa-solid fa-book-open-reader"></i></h1> <span class="setting-icon-text"> Accounts</span>
          </a>
          <a href="/setting/warehouses" class="setting-icon-action">
              <h1><i class="fa-solid fa-warehouse"></i></h1> <span class="setting-icon-text"> Warehouse</span>
          </a>
          <!-- <a href="#" class="setting-icon-action">
              <h1><i class="fa-solid fa-users-line"></i></h1> <span class="setting-icon-text"> Employes</span>
          </a> -->
      </div>
       <!-- End Content -->
        </main>
    </div>


@endsection