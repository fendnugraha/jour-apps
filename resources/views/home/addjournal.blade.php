@extends('include.main')

@section('container')
<div class="card">
  <div class="card-body">
    
<form action="/home/addjournal" method="post">
@csrf
    <div class="row mb-3">
      <label for="waktu" class="col-sm-2 col-form-label">Waktu</label>
      <div class="col-sm-10">
        <input type="datetime-local" class="form-control" id="waktu" name="waktu" value="{{ old('waktu') }}">
      </div>
    </div>
    <div class="row mb-3">
      <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword3">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
</form>
</div>
</div>
@endsection