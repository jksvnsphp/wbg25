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
                            <div class="col-md-12 text-center">
                                <img style="height:8rem;" src="{{ asset('uploads/success.gif') }}" alt="Order Success GIF">
                            </div>
                            <h5 class="text-success fs-5 text-center">Congratulation, your order has been placed
                                successfully.</h5>
                            <div class="col-sm-12 col-md-12 my-3">
                                <div class="table-responsive">
                                    <table class="table align-middle table-bordered ">
                                        <thead>
                                            <tr>
                                                <th width="20">Image</th>
                                                <th>Name</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($order->orderItems))
                                                @foreach ($order->orderItems as $orderItem)
                                                    @php
                                                        // Decode variants safely
                                                        $cartVariant = is_string($orderItem->variant)
                                                            ? json_decode($orderItem->variant, true)
                                                            : $orderItem->variant;
                                                        $variants = is_string($orderItem->product->variants)
                                                            ? json_decode($orderItem->product->variants, true)
                                                            : $orderItem->product->variants;
                                                        $variants = is_array($variants) ? $variants : [];

                                                        // Collect all images from combinations
                                                        $allImages = [];
                                                        foreach ($variants as $variant) {
                                                            if (
                                                                isset($variant['attributes']) &&
                                                                $variant['attributes'] == $cartVariant
                                                            ) {
                                                                if (
                                                                    !empty($variant['images']) &&
                                                                    is_array($variant['images'])
                                                                ) {
                                                                    $allImages = array_merge(
                                                                        $allImages,
                                                                        $variant['images'],
                                                                    );

                                                                    break;
                                                                }
                                                            }
                                                        }

                                                        // Pick the first valid image
                                                        $previewImage = !empty($allImages)
                                                            ? asset('uploads/products/' . $allImages[0])
                                                            : null;

                                                        // Fallback to gallery or placeholder
                                                        if (empty($previewImage)) {
                                                            $previewImage =
                                                                isset($orderItem->product->gallery[0]->image) &&
                                                                !empty($orderItem->product->gallery[0]->image)
                                                                    ? asset(
                                                                        'uploads/products/gallery/' .
                                                                            $orderItem->product->gallery[0]->image,
                                                                    )
                                                                    : 'https://placehold.co/600x400';
                                                        }
                                                    @endphp
                                                    
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('product.detail',$orderItem->product->slug) }}">
                                                                <img style="height: 5rem; width:5rem;" class="rounded-2"
                                                                    src="{{ $previewImage }}" alt="">
                                                            </a>
                                                        </td>
                                                        <td>
                                                          <a href="{{ route('product.detail',$orderItem->product->slug) }}" style="white-space:normal;" class="d-block text-primary fw-bold">
                                                            {{ $orderItem->product_name }}
                                                          </a>
                                                        </td>
                                                        <td>
                                                            {{ $orderItem->quantity }}
                                                        </td>
                                                        <td>
                                                           US$ {{ $orderItem->total_price }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                
                                                <th colspan="3">Shipping Cost</th>
                                                
                                                <th>US$ {{ $order->shipping_cost }}</th>
                                            </tr>
                                            <tr>
                                                
                                                <th colspan="3">Total Amount</th>
                                                
                                                <th>US$ {{ floatval($order->total_amount)+floatval($order->shipping_cost) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <p class="card-text text-center mb-0 ">
                                Thank you for your purchase! Your order number is <span
                                    class="order-number fw-bolder">{{ session('order_number') }}</span>.
                            </p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
                            </div>
                            <p class="card-text text-center text-muted">We’re processing your order and will notify you when
                                it’s on the way.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
