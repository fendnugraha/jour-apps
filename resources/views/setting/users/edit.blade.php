@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <div class="row">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                
                        <form action="/setting/user/{{ $user->id }}/edit" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-2 row">
                                <label for="email" class="col-sm col-form-label">Email Address</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email') == null ? $user->email : old('email')}}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <small>{{ $message }}</small>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="name" class="col-sm col-form-label">Full Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') == null ? $user->name : old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <small>{{ $message }}</small>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="warehouse" class="col-sm col-form-label">Warehouse (Gudang)</label>
                                <div class="col-sm-8">
                                    <select name="warehouse" class="form-control" id="warehouse" @error('warehouse') is-invalid @enderror>
                                        @foreach ($warehouses as $wh)
                                            <option value="{{ $wh->id }}" {{ old('warehouse') == $wh->id ? 'selected' : '' }}>{{ $wh->w_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('warehouse')
                                    <div class="invalid-feedback">
                                        <small>{{ $message }}</small>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label for="role" class="col-sm col-form-label">Role</label>
                                <div class="col-sm-8">
                                    <select name="role" class="form-control" id="role">
                                        <option value="Administrator" {{ $user->role == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                        <option value="Kasir" {{ $user->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                                        <option value="Staff" {{ $user->role == 'Staff' ? 'selected' : '' }}>Staff</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <div class="col-sm-8">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="/setting/users" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                
            </div>
        </div>
        
       <!-- End Content -->
        </main>
    </div>


@endsection 