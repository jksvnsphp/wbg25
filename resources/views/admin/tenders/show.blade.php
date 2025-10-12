@extends('admin.main-dashboard-frame')

@section('admin-content')
<div class="container mt-4">
    <h1 class="mb-3">Tender Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $tender->name }}</h3>
            <p><strong>Slug:</strong> {{ $tender->slug }}</p>
            <p><strong>Description:</strong> {!! $tender->description !!}</p>
            <p><strong>Price:</strong> ${{ $tender->price }}</p>
            <p><strong>Quantity:</strong> {{ $tender->quantity }}</p>
            <p><strong>Currency:</strong> {{ $tender->currency }}</p>
            <p><strong>Category ID:</strong> {{ $tender->category_id }}</p>
            <p><strong>Tender Condition:</strong> {{ $tender->tender_condition }}</p>
            <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($tender->created_at)->format('m/d/Y') }}</p>
            <p><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($tender->updated_at)->format('m/d/Y') }}</p>
        </div>
    </div>

    {{-- Tender Images --}}
    <div class="mt-4">
        <h4>Images</h4>
        <div class="row">
            @foreach (['image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6'] as $img)
                @if (!empty($tender->$img))
                    <div class="col-md-2 mb-3">
                        <img src="{{ asset('storage/products/' . $tender->$img) }}" alt="Tender Image" class="img-fluid rounded">
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('sell.trade.list') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
