@extends('include.main')

@section('container')

<form action="/report/balance-sheet" method="post" class="form-inline my-3">
    @csrf
        <label for="end_date">Sampai</label>
        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $end_date }}">
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>

<div class="row">
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4>Total Assets</h4>
                <h1><i class="fa-solid fa-bank"></i> {{ number_format(intval($assets->flatten()->sum('balance'))) }}</h1>

            </div>
        </div>
    </div>
    <div class="col-sm">
        <div class="card">
            <div class="card-body">
                <h4>Total Liabilities</h4>
                <h1><i class="fa-solid fa-file-invoice-dollar"></i> {{ number_format(intval($liabilities->flatten()->sum('balance') + $equity->flatten()->sum('balance'))) }}</h1>

            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-sm">
        @foreach ($assets as $accountGroup)
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
        @foreach ($liabilities as $accountGroup)
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

        @foreach ($equity as $accountGroup)
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

</div>
   

@endsection