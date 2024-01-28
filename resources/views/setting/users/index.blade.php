@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <a href="/setting" class="btn btn-primary mb-3"><i class="fa-solid fa-arrow-left"></i> Go back</a>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUser">
    <i class="fa-solid fa-plus"></i> Add new user
 </button>
  
<table class="table display-no-order">
<thead>
<tr>
    <th>#ID</th>
    <th>User name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Registered at</th>
    <th>Last login</th>
    <th>status</th>
    <th>Warehouse</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
    @foreach ($users as $u)
    <tr>
        <td>{{ $u->created_at }}</td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->role }}</td>
        <td>{{ $u->created_at }}</td>
        <td>{{ date('Y-m-d H:i:s', strtotime($u->last_login)) }}</td>
        <td>{!! $u->status == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
        <td>{{ $u->warehouse->w_name }}</td>
        <td>
            <a href="/setting/user/{{ $u->id }}/edit" class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            {{-- <form action="{{ route('users.delete', $u->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                </button>
            </form> --}}
        </td>
    </tr>
    @endforeach
</tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addUserLabel">Add User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/setting/user/add" method="post">
            @csrf
            <input type="hidden" name="logged_in" value="logged_in">
            <div class="mb-2 row">
                <label for="email" class="col-sm col-form-label">Email Address</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email')}}">
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
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="password" class="col-sm col-form-label">Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="">
                    @error('password')
                    <div class="invalid-feedback">
                        <small>{{ $message }}</small>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="mb-2 row">
                <label for="cpassword" class="col-sm col-form-label">Confirm Password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control @error('cpassword') is-invalid @enderror" name="cpassword" id="cpassword" value="">
                    @error('cpassword')
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
                        <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Administrator</option>
                        <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Kasir</option>
                        <option value="3" {{ old('role') == 3 ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>
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
       <!-- End Content -->
        </main>
    </div>


@endsection 