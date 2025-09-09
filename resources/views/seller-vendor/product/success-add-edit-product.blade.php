@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card my-4 py-3 rounded-0 shadow">
                    <div class="image bg-white d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('seller.vendor.gallery') }}" style="height: 5rem; width: 5rem"
                            class="rounded-circle overflow-hidden">
                            <img style=" height: 100%; width: 100%; object-fit: fill;  object-position: center;border-radius: 50%; "
                                src="@if ($seller->profile != '') {{ asset('uploads/profile/' . $seller->profile) }}
                                @else
                                    https://www.shutterstock.com/image-vector/vector-design-avatar-dummy-sign-600nw-1290556063.jpg @endif" />
                        </a>
                        <span class="name mt-3 fs-5 fw-bolder">Hi {{ $seller->first_name }}</span>
                        <small class="text-muted"><i class="fa fa-envelope me-2" aria-hidden="true"></i>
                            {{ $seller->email }}</small>
                        <small class="text-muted"><i class="fa me-2 fa-phone" aria-hidden="true"></i> {{ $seller->phone }}
                        </small>

                        <div class="d-flex mt-3">
                            <a href="{{ route('seller.edit.registration', $seller->ref_no) }}" class="btn btn-primary">Edit
                                Profile</a>
                        </div>
                        <div class="my-2">
                            <span style="font-size: 13px" class="fw-bold d-block text-center">Member Status:
                                {{ $packageData->package->name }}</span>
                            <span style="font-size: 13px" class="fw-bold d-block text-center">Expiry Date:
                                {{ date('d-m-Y', strtotime($packageData->expire_at)) }}</span>
                        </div>
                        <a href="{{ route('user.member.package') }}" class="btn btn-secondary mt-2">
                            Upgrade Member Package
                        </a>
                    </div>
                </div>

               
            </div>
            <div class="col-md-9">
                <div class="card shadow rounded-0 my-4">
                    
                    <div class="card-body">
                        <div class="row details-card-v justify-content-center">
                            <h5 class="text-success fs-5 text-center">Congratulation, your product has {{ $what=="add"?"uploaded":"edited" }} successfully and listed
                                online now!</h5>
                            <div class="col-sm-6 col-md-8 my-3">
                                <div class="card rounded-0 shadow-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                @php
                                                // Decode variants safely
                                                $variants = is_string($product->variants)
                                                    ? json_decode($product->variants, true)
                                                    : $product->variants;
                                                $variants = is_array($variants) ? $variants : [];

                                                // Collect all images from combinations
                                                $allImages = [];
                                                foreach ($variants as $variant) {
                                                    if (
                                                        !empty($variant['images']) &&
                                                        is_array($variant['images'])
                                                    ) {
                                                        $allImages = array_merge(
                                                            $allImages,
                                                            $variant['images'],
                                                        );
                                                    }
                                                }

                                                // Pick the first valid image
                                                $previewImage = !empty($allImages)
                                                    ? asset('uploads/products/' . $allImages[0])
                                                    : null;

                                                // Fallback to gallery or placeholder
                                                if (empty($previewImage)) {
                                                    $previewImage =
                                                        isset($product->gallery[0]->image) &&
                                                        !empty($product->gallery[0]->image)
                                                            ? asset(
                                                                'uploads/products/gallery/' .
                                                                    $product->gallery[0]->image,
                                                            )
                                                            : 'https://placehold.co/600x400';
                                                }
                                            @endphp
                                                <img src="{{ $previewImage }}"
                                                    alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="text-dark fw-bolder"> {{ $product->name }}</h5>
                                                <a class="d-block text-primary mt-2" href="{{ route('product.detail', $product->slug) }}">View Listed Product</a>
                                                <a class="d-block text-primary mt-2" href="@if($product->isMultiple==1)
                                                  {{ route('seller.edit.multiply-list', $product->id) }}
                                                  @else
                                                  {{ route('seller.edit.product', $product->id) }}

                                                @endif">Edit Listed Product</a>
                                                <a class="d-block text-primary mt-2" href="{{ route('seller.add.product') }}">Add New Product</a>
                                                <a class="d-block text-primary mt-2" href="{{ route('seller.multiple-listing') }}">Add Multiply Product</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
                            </div>
                            <h5 class="text-center mt-3 fw-bold">Next Step:</h5>
                            <p class="text-center">Please prepare the package to ship your item before the processing time expires.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
