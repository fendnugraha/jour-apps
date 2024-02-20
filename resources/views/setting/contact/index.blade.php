@extends('include.main')

@section('container')

    @include('include.sidebar')
    <div class="main-content">
        @include('include.topbar')

        <main class="content">
        <!-- Content  -->
        <a href="/setting" class="btn btn-primary mb-3"><i class="fa-solid fa-arrow-left"></i> Go back</a>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addContact">
    <i class="fa-solid fa-plus"></i> Add Contact
 </button>
  
<table class="table display-no-order">
<thead>
<tr>
    <th>Date Created</th>
    <th>Contact name</th>
    <th>Type</th>
    <th>Description</th>
    <th>ACTION</th>
</tr>
</thead>
<tbody>
    @foreach ($contacts as $c)
    <tr>
        <td>{{ $c->created_at }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ strtoupper($c->type) }}</td>
        <td>{{ $c->description }}</td>
        <td>
            <a href="/setting/contacts/{{ $c->id }}/edit" class="btn btn-warning btn-sm">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <form action="{{ route('contact.delete', $c->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="addContactLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addContactLabel">Add Contact</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/setting/contacts/add" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Contact name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Contact type</label>
                <select name="type" id="type" class="form-select {{ $errors->has('type') ? 'is-invalid' : '' }}">
                    <option value="customer" {{ old('type') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="supplier" {{ old('type') == 'supplier' ? 'selected' : '' }}>Supplier</option>
                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" value="{{ old('description') }}">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
        
       <!-- End Content -->
        </main>
    </div>


@endsection 