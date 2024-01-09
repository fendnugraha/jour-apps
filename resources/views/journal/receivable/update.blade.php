@extends('include.main')

@section('container')

<div class="card">
    <div class="card-body">
        <form action="/piutang/{{ $rcv->id }}/edit-detail" method="post">
            @csrf
            <div class="mb-2 row">
                <label for="date_issued" class="col-sm col-form-label">Tanggal</label>
                <div class="col-sm-8">
                    <input type="datetime-local" class="form-control @error('date_issued') is-invalid @enderror" name="date_issued" id="date_issued" value="{{old('date_issued') == null ? $rcv->date_issued : old('date_issued')}}">
                    @error('date_issued')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="debt_code" class="col-sm col-form-label">Akun Piutang</label>
                <div class="col-sm-8">
                    <select name="debt_code" id="debt_code" class="form-select @error('debt_code') is-invalid @enderror">
                        <option value="">Pilih Akun Piutang</option>
                        <option value="{{ $account_trace->debt_code }}" selected>{{ $account_trace->debt_code }} - {{ $account_trace->debt->acc_name }}</option>
                        @foreach ($rsvAccount as $ac)
                            <option value="{{ $ac->acc_code }}" {{old('debt_code') == $ac->acc_code ? 'selected' : ''}}>{{ $ac->acc_code }} - {{ $ac->acc_name }}</option>
                        @endforeach
                    </select>
                    @error('debt_code')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="debt_code" class="col-sm col-form-label">Sumber Dana</label>
                <div class="col-sm-8">
                    <select name="cred_code" id="cred_code" class="form-select @error('cred_code') is-invalid @enderror">
                        <option value="">Pilih Sumber Dana</option>
                        <option value="{{ $account_trace->cred_code }}" selected>{{ $account_trace->cred_code }} - {{ $account_trace->cred->acc_name }}</option>
                        @foreach ($rscFund as $ac)
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
                        <option value="{{ $rcv->contact->id }}" selected>{{ $rcv->contact->name }}</option>
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
                <label for="description" class="col-sm col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="description" id="description" cols="30" rows="3" class="form-control @error('description') is-invalid @enderror">{{old('description') == null ? $rcv->description : old('description')}}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-1 row">
                <label for="amount" class="col-sm col-form-label">Amount</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" id="amount" value="{{old('amount') == null ? $account_trace->amount : old('amount')}}">
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
            <a href="/piutang/{{ $rcv->contact->id }}/detail" class="btn btn-danger">Cancel</a>
        </div>
        </form>             
    </div>
</div>



@endsection