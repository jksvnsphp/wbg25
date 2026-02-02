@extends('admin.main-dashboard-frame')

@section('admin-content')
<div class="container-fluid">
    <h4>Tender Details</h4>

    <p><strong>Company:</strong>
        {{ $tender->vendor->company->name ?? 'N/A' }}
    </p>

    <p><strong>Title:</strong> {{ $tender->name }}</p>
    <p><strong>Quantity:</strong> {{ $tender->quantity }}</p>
    <p><strong>Entry Date:</strong> {{ $tender->created_at->format('d M Y') }}</p>
</div>
@endsection
