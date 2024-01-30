@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <form action="/hutang/add" method="post">
            @csrf
            <div class="mb-2 row">
                <label for="date_issued" class="col-sm col-form-label">Tanggal</label>
                <div class="col-sm-8">
                    <input type="datetime-local" class="form-control @error('date_issued') is-invalid @enderror" name="date_issued" id="date_issued" value="{{old('date_issued') == null ? date('Y-m-d H:i') : old('date_issued')}}">
                    @error('date_issued')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="debt_code" class="col-sm col-form-label">Sumber Dana</label>
                <div class="col-sm-8">
                    <select name="debt_code" class="form-select @error('debt_code') is-invalid @enderror" id="debt-code-payable">
                        <option value="">Pilih Sumber Dana</option>
                        @foreach ($rscFund as $ac)
                            <option value="{{ $ac->acc_code }}" {{old('debt_code') == $ac->acc_code ? 'selected' : ''}}>{{ $ac->acc_name }} - {{ $ac->acc_code }}</option>
                        @endforeach
                    </select>
                    @error('debt_code')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                    <div class="form-check mt-2">
                    <input type="checkbox" name="debt_code" id="modal-checkbox-payable" value="30100-001" class="form-check-input">
                    <label for="modal-checkbox-payable" class="form-check-label">Jadikan saldo awal hutang (Modal)</label>
                    </div>
                </div>
            </div>
            <div class="mb-2 row">
                <label for="cred_code" class="col-sm col-form-label">Akun Hutang</label>
                <div class="col-sm-8">
                    <select name="cred_code" id="cred_code" class="form-select @error('cred_code') is-invalid @enderror">
                        <option value="">Pilih Akun Hutang</option>
                        @foreach ($account as $ac)
                            <option value="{{ $ac->acc_code }}" {{old('cred_code') == $ac->acc_code ? 'selected' : ''}}>{{ $ac->acc_name }} - {{ $ac->acc_code }}</option>
                        @endforeach
                    </select>
                    @error('cred_code')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="contact" class="col-sm col-form-label">Contact</label>
                <div class="col-sm-8">
                    <select name="contact" id="contact" class="form-select @error('contact') is-invalid @enderror">
                        <option value="">Pilih Contact</option>
                        @foreach ($contacts as $ct)
                            <option value="{{ $ct->id }}" {{old('contact') == $ct->id ? 'selected' : ''}}>{{ $ct->name }}</option>
                        @endforeach
                    </select>
                    @error('contact')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="description" class="col-sm col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="description" id="description" cols="30" rows="3" class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="amount" class="col-sm col-form-label">Jumlah</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{old('amount')}}">
                    @error('amount')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="d-flex mt-3 justify-content-start gap-2 align-items-center">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
            <a href="/hutang" class="btn btn-danger">Cancel</a>
        </div>
        </form>   
       <!-- End Content -->
    </main>
    </div>


@endsection