@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">


        <!-- Content  -->
        <div class="card">
            <div class="card-body">
                <form action="/setting/accounts/add" method="post">
                    @csrf
                    <div class="mb-2 row">
                        <label for="acc_name" class="col-sm col-form-label">Nama Akun</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('acc_name') is-invalid @enderror" name="acc_name" id="acc_name" value="{{old('acc_name')}}">
                            @error('acc_name')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="acc_type" class="col-sm col-form-label">Tipe Akun</label>
                        <div class="col-sm-8">
                            <select name="acc_type" id="acc_type" class="form-select @error('acc_type') is-invalid @enderror">
                                <option value="">Pilih Tipe Akun</option>
                               @foreach ($accounts as $ac)
                                   <option value="{{ $ac->id }}" {{old('id') == $ac->id ? 'selected' : ''}}>{{ $ac->name }} - {{ $ac->code }}</option>                           
                               @endforeach
                            </select>
                            @error('acc_type')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="st_balance" class="col-sm col-form-label">Saldo Awal</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control @error('st_balance') is-invalid @enderror" name="st_balance" id="st_balance" value="{{old('st_balance') == null ? 0 : old('st_balance')}}">
                            @error('st_balance')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex mt-3 justify-content-start gap-2 align-items-center">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <a href="/setting/accounts" class="btn btn-danger">Cancel</a>
                </div>
                </form>
            </div>
        </div>

        </main>
@endsection 