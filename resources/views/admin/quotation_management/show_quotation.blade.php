@extends('admin.main-dashboard-frame')

@section('admin-content')
<div class="container mt-4">
    <h1 class="mb-3">Service Inquiry Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $inquiry->product_service }}</h3>
            <p><strong>Slug:</strong> {{ $inquiry->slug }}</p>
            <p><strong>Requirement Details:</strong> {!! $inquiry->requirement_details !!}</p>
            <p><strong>Type:</strong> {{ $inquiry->type }}</p>
            <p><strong>Quantity:</strong> {{ $inquiry->quantity }}</p>
            <p><strong>Currency:</strong> {{ $inquiry->currency }}</p>
            <p><strong>Price:</strong> ${{ number_format($inquiry->price, 2) }}</p>
            <p><strong>Duration (days):</strong> {{ $inquiry->duration }}</p>
            <p><strong>Category ID:</strong> {{ $inquiry->category_id }}</p>
            <p><strong>Subcategory ID:</strong> {{ $inquiry->subcategory_id }}</p>
            <p><strong>Status:</strong> {{ ucfirst($inquiry->status) }}</p>
            <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($inquiry->created_at)->format('m/d/Y h:i A') }}</p>
            <p><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($inquiry->updated_at)->format('m/d/Y h:i A') }}</p>
        </div>
    </div>

    {{-- Images --}}
    <div class="mt-4">
        <h4>Images</h4>
        <div class="row">
            @foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $img)
                @if (!empty($inquiry->$img))
                    <div class="col-md-3 mb-3">
                        <img src="{{ asset('storage/products/' . $inquiry->$img) }}" alt="Image" class="img-fluid rounded">
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.quotations') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
