@extends('include.main')

@section('container')

<div class="card">
    <div class="card-body">
        <table class="table display">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Saldo Awal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $a)
                    
                <tr>
                    <td>{{ $a->acc_code }}</td>
                    <td>{{ $a->acc_name }}</td>
                    <td>{{ $a->account->name . ' / ' . $a->account->status . ' / ' .  $a->account->type}} </td>
                    <td>{{ number_format($a->st_balance) }}</td>
                    <td>Action</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection