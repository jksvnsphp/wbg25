@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container">
    <h4>Edit Certificate</h4>
    <form action="{{ route('admin.certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Vendor</label>
            <select name="vendor_id" class="form-control" required>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ $certificate->vendor_id == $vendor->id ? 'selected' : '' }}>
                        {{ $vendor->first_name }} {{ $vendor->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="{{ asset('storage/' . $certificate->image) }}" width="120" class="mb-2">
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
