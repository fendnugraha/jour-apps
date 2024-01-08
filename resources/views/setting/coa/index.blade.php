@extends('include.main')

@section('container')
<a href="/setting" class="btn btn-primary mb-3"><i class="fa-solid fa-arrow-left"></i> Go back</a>
<a href="/setting/accounts/add" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i> Add Account</a>
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
                    <td>
                        <a href="/setting/accounts/{{ $a->id }}/edit" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('coa.delete', $a->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

@endsection