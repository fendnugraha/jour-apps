@extends('include.main')

@section('container')
<div class="card">
    <div class="card-body">
        <div class="setting-icon d-flex justify-content-between flex-wrap gap-3">
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
            <a href="/setting/warehouse" class="setting-icon-action">
                <h1><i class="fa-solid fa-warehouse"></i></h1> <span class="setting-icon-text"> Warehouse</span>
            </a>
            <!-- <a href="#" class="setting-icon-action">
                <h1><i class="fa-solid fa-users-line"></i></h1> <span class="setting-icon-text"> Employes</span>
            </a> -->
        </div>
    </div>
</div>


@endsection