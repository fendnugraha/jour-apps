@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">


        <!-- Content  -->
        <h1>Init: {{ $initEquity }}</h1>
        <h1>Last: {{ $lastEquity }}</h1>
       


        </main>
@endsection 