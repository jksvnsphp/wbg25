@extends('admin.main-dashboard-frame')

@section('admin-content')
<div class="container-fluid">

    <h4>Product Video Details</h4>

    <p><strong>Product:</strong> {{ $product->name }}</p>
    <p><strong>Company:</strong> {{ $product->vendor->company->name ?? 'N/A' }}</p>

    @if($product->video && $product->video->video_url)
        <video width="500" controls>
            <source src="{{ asset($product->video->video_url) }}" type="video/mp4">
        </video>
    @else
        <p>No video available</p>
    @endif

</div>
@endsection
