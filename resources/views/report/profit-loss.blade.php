@extends('include.main')

@section('container')

<div class="row">
    <div class="col-sm">
        <form action="/report/profit-loss" method="post" class="form-inline my-3">
            @csrf
            <div class="row">
                <div class="form-group col">
                    <label for="start_date">Dari</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $start_date }}">
                </div>
                <div class="form-group col">
                    <label for="end_date">Sampai</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $end_date }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
    <div class="col-sm">
        
    </div>
</div>

<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4>Total Revenue</h4>
                <h1><i class="fa-solid fa-cash-register"></i> {{ number_format(intval($revenue->flatten()->sum('balance'))) }}</h1>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4>Net Profit</h4>
                <h1><i class="fa-solid fa-file-invoice"></i> {{ number_format(intval($revenue->flatten()->sum('balance') + $cost->flatten()->sum('balance')) - $expense->flatten()->sum('balance')) }}</h1>

            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-sm">
        @foreach ($revenue as $accountGroup)
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2">{{ $accountGroup->first()->account->name }}</th>
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
                    <th colspan="2">{{ $accountGroup->first()->account->name }}</th>
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
                    <th colspan="2">{{ $accountGroup->first()->account->name }}</th>
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
   

@endsection