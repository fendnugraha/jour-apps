@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">


        <!-- Content  -->
        <a href="/setting" class="btn btn-primary mb-3"><i class="fa-solid fa-arrow-left"></i> Go back</a>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addContact">
    <i class="fa-solid fa-plus"></i> Add warehouse
 </button>
  
<table class="table display-no-order">
<thead>
<tr>
    <th>#ID</th>
    <th>Code</th>
    <th>Name</th>
    <th>Address</th>
    <th>Account ID</th>
    <th>Created at</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
    @foreach ($warehouse as $w)
    <tr>
        <td>{{ $w->id }}</td>
        <td>{{ $w->w_code }}</td>
        <td>{{ $w->w_name }}</td>
        <td>{{ $w->address }}</td>
        <td>{{ $w->chartofaccount->acc_name }}</td>
        <td>{{ $w->created_at }}</td>
        <td>
            <a href="/setting/warehouse/{{ $w->id }}/edit" class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <form action="{{ route('warehouse.delete', $w->id) }}" method="POST" class="d-inline">
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
<!-- Modal -->
<div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="addContactLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addContactLabel">Add Warehouse</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/setting/warehouse/add" method="post">
            @csrf
            <div class="mb-3">
                <label for="w_code" class="form-label">Warehouse code</label>
                <input type="text" class="form-control {{ $errors->has('w_code') ? 'is-invalid' : '' }}" id="w_code" name="w_code" value="{{ old('w_code') }}">
                @error('w_code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="w_name" class="form-label">Warehouse name</label>
                <input type="text" class="form-control {{ $errors->has('w_name') ? 'is-invalid' : '' }}" id="w_name" name="w_name" value="{{ old('w_name') }}">
                @error('w_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="account" class="form-label">Cash Account</label>
                <select name="account" id="account" class="form-select {{ $errors->has('account') ? 'is-invalid' : '' }}">
                    <option value="">Pilih Akun</option>
                    @foreach ($account as $ac)
                        <option value="{{ $ac->id }}" {{ old('account') == $ac->id ? 'selected' : '' }}>{{ $ac->acc_name }} - {{ $ac->acc_code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">address</label>
                <textarea name="address" id="address" cols="30" rows="5" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" value="{{ old('address') }}">{{ old('address') }}</textarea>
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

        </main>
@endsection 