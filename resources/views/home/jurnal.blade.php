@extends('include.main')

@section('container')
<div class="card">
    <div class="card-body">
        <table class="table display">
            <thead>
                <tr>
                    <th>WAKTU</th>
                    <th>INVOICE</th>
                    <th>DESKRIPSI</th>
                    <th>JUMLAH</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accountTrace as $acctrace)
                    
                
                <tr>
                    <td>{{ $acctrace->waktu }}</td>
                    <td>{{ $acctrace->invoice }}</td>
                    <td>{{ $acctrace->description }}</td>
                    <td>{{ $acctrace->jumlah }}</td>
                    <td>{{ $acctrace->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection