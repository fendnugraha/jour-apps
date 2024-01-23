@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
            <div class="row">
                <div class="col-sm">
                    <h2>User Profile</h2>
                    <form action="/setting/general/{{ Auth::user()->id }}/update" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ Auth::user()->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ Auth::user()->email }}">
                            @error('email')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="Administrator" {{ Auth::user()->role == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                <option value="Kasir" {{ Auth::user()->role == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="Staff" {{ Auth::user()->role == 'Staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="warehouse">Warehouse</label>
                            <select name="warehouse" id="warehouse" class="form-select @error('warehouse') is-invalid @enderror">
                                @foreach ($warehouses as $w)
                                    <option value="{{ $w->id }}" {{ Auth::user()->warehouse_id == $w->id ? 'selected' : '' }}>{{ $w->w_code }} - {{ $w->w_name }}</option>
                                @endforeach
                            </select>
                            @error('warehouse')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Old Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                            @error('password')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="newPassword">New Password</label>
                            <input type="password" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword" id="newPassword">
                            @error('newPassword')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="cNewPassword">Confirm New Password</label>
                            <input type="password" class="form-control @error('cNewPassword') is-invalid @enderror" name="cNewPassword" id="cNewPassword">
                            @error('cNewPassword')
                            <div class="invalid-feedback">
                                <small>{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>

                    </form>
                </div>
                <div class="col-sm">
                </div>
            </div>
       


        </main>
@endsection 