@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">


        <!-- Content  -->
        <h1>Test: {{ $test }}</h1>
        <h1>profit: {{ $profit }}</h1>
       


        </main>
@endsection 