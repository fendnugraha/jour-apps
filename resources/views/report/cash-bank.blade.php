@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
            <div class="row">
                <div class="col-sm">
                    <div class="card text-bg-dark card-widget">
                        <div class="card-body">
                            <h4>Total Cash & Bank</h4>
                            <h1><i class="fa-solid fa-bank"></i> {{ number_format(intval($cashBank->flatten()->sum('balance'))) }}</h1>
            
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                </div>
            </div>
            <form action="/report/cash-bank" method="post" class="form-inline mt-3">
                @csrf
                <div class="row align-items-center">
                    <div class="col-1">
                        <label for="end_date">Sampai</label>
                    </div>
                    <div class="col-4">
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ date('Y-m-d') == null ? date('Y-m-d') : $end_date }}">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
            <div class="row mt-4">
                <div class="col-sm-8">
                    @foreach ($cashBank as $accountGroup)
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
                </div>
            </div>

        </main>
@endsection 