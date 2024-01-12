@extends('include.main')

@section('container')
<div class="card">
    <div class="card-body">
<form action="/setting/warehouse/{{ $warehouse->id }}/edit" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="w_code" class="form-label">Warehouse Code</label>
        <input type="text" class="form-control {{ $errors->has('w_code') ? 'is-invalid' : '' }}" id="w_code" name="w_code" value="{{ old('w_code') ?? $warehouse->w_code }}">
        @error('w_code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="w_name" class="form-label">Warehouse Name</label>
        <input type="text" class="form-control {{ $errors->has('w_name') ? 'is-invalid' : '' }}" id="w_name" name="w_name" value="{{ old('w_name') ?? $warehouse->w_name }}">
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
                <option value="{{ $ac->id }}" {{ $warehouse->chart_of_account_id == $ac->id ? 'selected' : '' }}>{{ $ac->acc_code }} - {{ $ac->acc_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">address</label>
        <textarea name="address" id="address" cols="30" rows="5" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" value="{{ old('address') ?? $warehouse->address }}">{{ old('address') ?? $warehouse->address }}</textarea>
        @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>


    <button type="submit" class="btn btn-success">Update</button>
    <a href="/setting/warehouses" class="btn btn-danger">Cancel</a>
</form>

        
</div>
</div>

@endsection