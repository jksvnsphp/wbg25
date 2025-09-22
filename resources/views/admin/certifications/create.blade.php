@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container">
    <h4>Add Certificate</h4>
    <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Vendor</label>
            <select name="vendor_id" class="form-control" required>
                <option value="">-- Select Vendor --</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->first_name }} {{ $vendor->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Certificate Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
