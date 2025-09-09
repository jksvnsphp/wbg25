@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <style>
        .table-img {
            width: 100px;
            height: 100px;

        }

        .table-img img {
            border-radius: 10px;
        }
    </style>
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div class="spinner-border text-light" role="status"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My Sold Products</h6>

                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th colspan="2">Information</th>
                                        <th>Quantity</th>
                                        <th>Purchased</th>
                                        <th>Amount</th>
                                        <th>Status & Details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        @foreach ($order->orderItems as $item)
                                            @php
                                                // Decode variants safely
                                                $variants = is_string($item->product->variants)
                                                    ? json_decode($item->product->variants, true)
                                                    : $item->product->variants;
                                                $variants = is_array($variants) ? $variants : [];
                                                $allImages = [];
                                                foreach ($variants as $variant) {
                                                    if (!empty($variant['images']) && is_array($variant['images'])) {
                                                        $allImages = array_merge($allImages, $variant['images']);
                                                    }
                                                }
                                                $previewImage = !empty($allImages)
                                                    ? asset('uploads/products/' . $allImages[0])
                                                    : null;
                                                if (empty($previewImage)) {
                                                    $previewImage =
                                                        isset($item->product->gallery[0]->image) &&
                                                        !empty($item->product->gallery[0]->image)
                                                            ? asset(
                                                                'uploads/products/gallery/' .
                                                                    $item->product->gallery[0]->image,
                                                            )
                                                            : 'https://placehold.co/600x400';
                                                }
                                            @endphp
                                            <tr @if($item->isRead==0) class="table-info"   @endif>
                                                <td>
                                                    <a href="{{ route('product.detail', $item->product->slug) }}"
                                                        class="rounded-2 d-block"
                                                        style="height:5rem !important; width:5rem !important;">
                                                        <img src="{{ $previewImage }}" style="height: 100%; width: 100%"
                                                            class="rounded-2" alt="" />
                                                    </a>
                                                </td>
                                                <td>
                                                    <p style="width: 10rem">
                                                        {{ $item->product->name }}
                                                    </p>
                                                </td>
                                                <td>
                                                    {{ $item->quantity }}
                                                </td>
                                                <td>
                                                    <h6 class="text-center">Purchased
                                                        {{ date('d M, Y', strtotime($item->created_at)) }}</h6>
                                                    <h6 class="text-center">CET
                                                        {{ date('h:i A', strtotime($item->created_at)) }}</h6>
                                                </td>
                                                <td>
                                                    <span class="text-secondary fw-semibold">
                                                        &euro; {{ $item->total_price }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center text-capitalize ">
                                                            <span class="fw-bold fs-6 me-1">Status:</span>
                                                            {{ $order->order_status }}
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('seller.sold.product.detail', $item->id) }}"
                                                                class="btn text-light btn-info">Details</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>

                                                    <a href="" class="btn btn-primary me-2"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr @if($item->isRead==0) class="table-info"   @endif>
                                                <th colspan="2">
                                                    Payment Status
                                                </th>
                                                <td>
                                                    @if ($item->payment_status == 'pending')
                                                        <span class="badge rounded-0 bg-warning">Not yet paid</span>
                                                    @elseif($item->payment_status == 'failed')
                                                        <span class="badge rounded-0 bg-danger">Failed</span>
                                                    @elseif($item->payment_status == 'cancelled')
                                                        <span class="badge rounded-0 bg-secondary">Cancelled</span>
                                                    @else
                                                        <span class="badge rounded-0 bg-success">Paid</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-center fw-bold"> OrderId: {{ $order->id }}</span>
                                                </td>
                                                <th>
                                                    Shipping Status
                                                </th>
                                                <th colspan="2">
                                                    @if ($item->shipment_status == 'pending')
                                                        <span class="badge rounded-0 bg-warning">Not yet Shipped</span>
                                                    @elseif($item->shipment_status == 'failed')
                                                        <span class="badge rounded-0 bg-secondary">Returned</span>
                                                    @elseif($item->shipment_status == 'cancelled')
                                                        <span class="badge rounded-0 bg-danger">Cancelled</span>
                                                    @elseif($item->shipment_status == 'delivered')
                                                        <span class="badge rounded-0 bg-success">Delivered</span>
                                                    @else
                                                        <span class="badge rounded-0 bg-success">Shipped</span>
                                                    @endif


                                                </th>
                                            </tr>
                                        @endforeach
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="d-flex justify-content-center ">
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light"><i
                            class="fas fa-arrow-left "></i> Back</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('seller-custome-js')
    <script>
        $(document).ready(function() {
            $('.payment-status-dropdown').on('change', function() {
                let paymentStatus = $(this).val();
                let orderId = $(this).data('order-id');
                $.ajax({
                    url: '{{ route('seller.update.order.status') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: orderId,
                        payment_status: paymentStatus
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>
@endsection
