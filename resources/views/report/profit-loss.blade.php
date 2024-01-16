@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">


        <!-- Content  -->        
        <div class="row">
            <div class="col-sm">
                <div class="card card-widget text-bg-dark">
                    <div class="card-body">
                        <h4>Total Revenue</h4>
                        <h1><i class="fa-solid fa-cash-register"></i> {{ number_format(intval($revenue->flatten()->sum('balance'))) }}</h1>
        
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card card-widget text-bg-dark">
                    <div class="card-body">
                        <h4>Net Profit</h4>
                        <h1><i class="fa-solid fa-file-invoice"></i> {{ number_format(intval($revenue->flatten()->sum('balance') - $cost->flatten()->sum('balance')) - $expense->flatten()->sum('balance')) }}</h1>
        
                    </div>
                </div>
            </div>
        </div>
        
        <form action="/report/profit-loss" method="post" class="row mt-3">
            @csrf
                <div class="form-group col d-flex gap-1 align-items-center">
                    <label for="start_date">Dari</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $start_date }}">
                </div>
                <div class="form-group col d-flex gap-1 align-items-center">
                    <label for="end_date">Sampai</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $end_date }}">
                </div>
                <div class="form-group col d-flex gap-1 align-items-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </form>
        <div class="row mt-4">
            <div class="col-sm">
                @foreach ($revenue as $accountGroup)
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ $accountGroup->first()->account->name }}</th>
                            <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accountGroup as $account)
                        <tr>
                            <td>{{ $account->acc_name }}</td>
                            <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endforeach
        
                @foreach ($cost as $accountGroup)
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ $accountGroup->first()->account->name }}</th>
                            <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accountGroup as $account)
                        <tr>
                            <td>{{ $account->acc_name }}</td>
                            <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endforeach
            </div>
            <div class="col-sm">
                @foreach ($expense as $accountGroup)
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ $accountGroup->first()->account->name }}</th>
                            <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accountGroup as $account)
                        @if($account->balance > 0)
                        <tr>
                            <td>{{ $account->acc_name }}</td>
                            <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                @endforeach
            </div>
        
        </div>


        </main>
@endsection 