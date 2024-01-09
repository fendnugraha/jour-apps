@extends('include.main')

@section('container')
<div class="card">
    <div class="card-body">
        <form action="/setting/contacts/{{ $contact->id }}/edit" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Contact name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" value="{{ old('name') ?? $contact->name }}">
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
                <textarea name="description" id="description" cols="30" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" value="{{ old('description') }}">{{ old('description') ?? $contact->description }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/setting/contacts" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>


@endsection