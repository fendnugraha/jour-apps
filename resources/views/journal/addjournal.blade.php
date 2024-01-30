@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <form action="/jurnal/addjournal" method="post">
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
              <label for="debt_code" class="col-sm col-form-label">Akun Debet</label>
              <div class="col-sm-8">
                  <select name="debt_code" id="debt_code" class="form-select @error('debt_code') is-invalid @enderror">
                      <option value="">Pilih Akun Debet</option>
                      @foreach ($account as $ac)
                          <option value="{{ $ac->acc_code }}" {{old('debt_code') == $ac->acc_code ? 'selected' : ''}}>{{ $ac->acc_name }} - {{ $ac->acc_code }}</option>
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
              <label for="cred_code" class="col-sm col-form-label">Akun Credit</label>
              <div class="col-sm-8">
                  <select name="cred_code" id="cred_code" class="form-select @error('cred_code') is-invalid @enderror">
                      <option value="">Pilih Akun Credit</option>
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
              <a href="/jurnal" class="btn btn-danger">Cancel</a>
            </div>
            </form>
       <!-- End Content -->
    </main>
    </div>


@endsection