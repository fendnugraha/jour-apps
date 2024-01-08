@extends('include.main')

@section('container')

<div class="card">
    <div class="card-body">
        <form action="/jurnal/addPiutang" method="post">
            @csrf
            <div class="mb-2 row">
                <label for="waktu" class="col-sm col-form-label">Waktu</label>
                <div class="col-sm-8">
                    <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror" name="waktu" id="waktu" value="{{old('waktu') == null ? date('Y-m-d H:i') : old('waktu')}}">
                    @error('waktu')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="cred_code" class="col-sm col-form-label">Akun Credit</label>
                <div class="col-sm-8">
                    <select name="cred_code" id="cred_code" class="form-select @error('cred_code') is-invalid @enderror">
                        <option value="">Pilih Akun Credit</option>
                        @foreach ($accounts as $ac)
                            <option value="{{ $ac->acc_code }}" {{old('cred_code') == $ac->acc_code ? 'selected' : ''}}>{{ $ac->acc_code }} - {{ $ac->acc_name }}</option>
                        @endforeach
                    </select>
                    @error('cred_code')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-1 row">
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
            <div class="mb-1 row">
                <label for="desciption" class="col-sm col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="desciption" id="desciption" cols="30" rows="3" class="form-control @error('desciption') is-invalid @enderror">{{old('desciption')}}</textarea>
                    @error('desciption')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-1 row">
                <label for="amount" class="col-sm col-form-label">Amount</label>
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
            <a href="/piutang" class="btn btn-danger">Cancel</a>
        </div>
        </form>             
    </div>
</div>



@endsection