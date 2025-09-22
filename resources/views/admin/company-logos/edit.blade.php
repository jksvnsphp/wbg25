@extends('admin.main-dashboard-frame')

@section('admin-content')
<div class="container-fluid">
    <h4>Edit Company Logo - {{ $company->name }}</h4>

    <form action="{{ route('admin.company-logos.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Current Logo</label><br>
            @if($company->company_logo)
                <img src="{{ asset('storage/company-logos/'.$company->company_logo) }}" width="120">
            @else
                <span class="text-muted">No Logo</span>
            @endif
        </div>

        <div class="mb-3">
            <label>Upload New Logo</label>
            <input type="file" name="company_logo" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.company-logos.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
