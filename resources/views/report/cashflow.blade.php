@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
            <div class="row mb-3">
                <div class="col-sm">
                    <div class="card card-widget text-bg-secondary">
                        <div class="card-body">
                            <h5>Kenaikan Penurunan Kas</h5>
                            <h2 class="text-end">{{ number_format(intval($growth)) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="card card-widget text-bg-secondary">
                        <div class="card-body">
                            <h5>Growth Rate (%)</h5>
                            <h2 class="text-end">{!! $percentageChange > 0 ? '<i class="fa-solid fa-circle-up text-light"></i>' : '<i class="fa-solid fa-circle-down text-danger"></i>' !!} {{ number_format($percentageChange, 2). ' %' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <form action="/report/cashflow" method="post" class="row my-3">
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
            <div class="col-sm">
                @foreach ($pendapatan as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <div class="col-sm">
                @foreach ($persediaan as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <div class="col-sm">
                @foreach ($investasi as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <div class="col-sm">
                @foreach ($assets as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
            
            <div class="col-sm">
                @foreach ($piutang as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <div class="col-sm">
                @foreach ($hutang as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <div class="col-sm">
                @foreach ($modal as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <div class="col-sm">
                @foreach ($biaya as $accountGroup)
                    <table class="table" {{$accountGroup->sum('balance') !== 0 ? '' : 'hidden'}}>
                        <thead>
                            <tr>
                                <th>{{ $accountGroup->first()->account->name }}</th>
                                <th class="text-end">{{ number_format(intval($accountGroup->sum('balance'))) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroup as $account)
                                <tr {{$account->balance !== 0 ? '' : 'hidden'}}>
                                    <td>{{ $account->acc_name }}</td>
                                    <td class="text-end">{{ number_format(intval($account->balance)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>

            <div class="col-sm">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>Saldo Awal Kas</th>
                                <th class="text-end">{{ number_format(intval($startBalance)) }}</th>
                            </tr>
                            <tr>
                                <th>Saldo Awal Akhir</th>
                                <th class="text-end">{{ number_format(intval($endBalance)) }}</th>
                            </tr>
                        </thead>
                    </table>
            </div>
            
       


        </main>
@endsection 