@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container mt-4">
    <h1 class="mb-3">Product Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $product->name }}</h3>
            <p><strong>Slug:</strong> {{ $product->slug }}</p>
            <p><strong>Description:</strong> {!! nl2br(e($product->description)) !!}</p>
            <p><strong>Price:</strong> ${{ $product->price }}</p>
            <p><strong>Condition:</strong> {{ $product->item_condition }}</p>
            <p><strong>Total Quantity:</strong> {{ $product->totalQty }}</p>
            <p><strong>Category ID:</strong> {{ $product->category_id }}</p>
            <p><strong>Created at:</strong> {{ $product->created_at }}</p>
            <p><strong>Updated at:</strong> {{ $product->updated_at }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection
