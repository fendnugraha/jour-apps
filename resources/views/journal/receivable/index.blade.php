@extends('include.main')

@section('container')

<div class="dropdown mb-2">
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-plus"></i> Add New
    </button>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="/piutang/addPiutang">Piutang</a></li>
      <li><a class="dropdown-item" href="/jurnal/addjournal">Piutang Awal</a></li>
      <li><a class="dropdown-item" href="/jurnal/addjournal">Piutang Saldo</a></li>
      <li><a class="dropdown-item" href="/jurnal/addjournal">Piutang Penjualan Barang</a></li>
    </ul>
</div>

<table class="table display-no-order">
<thead>
<tr>
    <th>WAKTU</th>
    <th>INVOICE</th>
    <th>DESKRIPSI</th>
    <th>JUMLAH</th>
    <th>ACTION</th>
</tr>
</thead>
<tbody>
    @foreach ($receivables as $rv)
    <tr>
         <td>{{ $rv->date_issued }}</td> 
         <td>{{ $rv->invoice }}</td>
         <td>{{ $rv->description }}</td>
         <td>{{ number_format($rv->amount) }}</td>
         <td>
            <a href="/jurnal/{{ $rv->id }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-eye"></i>
            </a>
         </td>  
    </tr>
    @endforeach
</tbody>
</table>


@endsection