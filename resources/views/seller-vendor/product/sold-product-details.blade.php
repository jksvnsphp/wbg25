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
                <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">
                    My Sold Product Details
                </h6>
            </div>
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
            $previewImage = !empty($allImages) ? asset('uploads/products/' . $allImages[0]) : null;
            if (empty($previewImage)) {
            $previewImage =
            isset($item->product->gallery[0]->image) && !empty($item->product->gallery[0]->image)
            ? asset('uploads/products/gallery/' . $item->product->gallery[0]->image)
            : 'https://placehold.co/600x400';
            }
            @endphp
            <div class="card rounded-0">
                <div class="card-body py-4">
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="table-img">
                                                    <img src="{{ $previewImage }}" style="height: 100%; width: 100%"
                                                        alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold mb-2" style="color: #FF7519;">Product Title : </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    {{ $item->product->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold mb-2" style="color: #FF7519;">Quantity : </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;"> {{ $item->quantity }} </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold mb-2" style="color: #FF7519;">Sold On : </div>
                                                <div class="fw-bold" style="color: #2E2B70;">
                                                    {{ date('d.M.y', strtotime($item->created_at)) }}
                                                </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    CET {{ date('h:i A', strtotime($item->created_at)) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold mb-2" style="color: #FF7519;">Sale Price : </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    USD {{ number_format($item->total_price) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold mb-2" style="color: #FF7519;">Sale Provision : </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    USD {{ number_format($item->total_price / 100 * 5) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-bold fs-6 me-1">Status:</span>
                                                        <img src="{{ asset('world-business/images/vendor-ico/businessdeal.jpg') }}" style="height: 5rem" alt="businessdeal" />
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3" style="border-right: 1px solid #ddd">
                                    <h6 class="fw-bold mb-3">Buyer Details</h6>
                                    <p class="mb-0">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</p>
                                    @if (isset($item->order->shipping_address))
                                    @php

                                    $shippingAddress = json_decode($item->order->shipping_address, true);
                                    $formattedAddress = implode(
                                    ', ',
                                    array_filter([
                                    $shippingAddress['street'] ?? null,
                                    $shippingAddress['house_no'] ?? null,
                                    $shippingAddress['city'] ?? null,
                                    $shippingAddress['state_name'] ?? null,
                                    $shippingAddress['country_name'] ?? null,
                                    $shippingAddress['postal_code'] ?? null,
                                    $shippingAddress['phone_number'] ?? null,
                                    ]),
                                    );
                                    @endphp
                                    <p class="mb-2">
                                        {{ $shippingAddress['city'] ?? null }}
                                        {{ $shippingAddress['house_no'] ?? null }}
                                        {{ $shippingAddress['street'] ?? null }}
                                        {{ $shippingAddress['postal_code'] ?? null }}
                                        {{ $shippingAddress['state_name'] ?? null }}
                                    </p>
                                    <p class="mb-0">{{ $shippingAddress['country_name'] ?? null }}</p>
                                    @endif
                                </div>
                                <div style="border-right: 1px solid #ddd" class="col-md-3 d-flex flex-column justify-content-start">
                                    <h6 class="fw-bold mb-3">Payment Details</h6>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="form-group me-2" style="max-width: 10rem !important;">
                                            @if ($item->payment_status == 'pending' || $item->payment_status == 'failed')
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button"
                                                onclick="changePayment({{ $item->id }}, 'paid')">Mark As
                                                Paid</button>
                                            @else
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button">Not Yet
                                                Paid</button>
                                            @endif
                                        </div>
                                        @if ($item->payment_status == 'pending')
                                        <span class="badge rounded-0 bg-warning">Not yet paid</span>
                                        @elseif($item->payment_status == 'failed')
                                        <span class="badge rounded-0 bg-danger">Failed</span>
                                        @elseif($item->payment_status == 'cancelled')
                                        <span class="badge rounded-0 bg-secondary">Cancelled</span>
                                        @else
                                        <span class="badge rounded-0 bg-success">Paid</span>
                                        @endif
                                    </div>
                                </div>
                                <div style="border-right: 1px solid #ddd" class="col-md-3 d-flex flex-column justify-content-center">
                                    <h6 class="fw-bold mb-3">Shippment Details</h6>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="form-group me-2" style="max-width: 12rem !important;">
                                            @if ($item->shipment_status == 'pending' || $item->shipment_status == 'cancelled')
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button"
                                                onclick="changeShipemnt({{ $item->id }}, 'shipped')">Mark As
                                                Shipped</button>
                                            @else
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button"
                                                onclick="changeShipemnt({{ $item->id }}, 'pending')">Not Yet
                                                Shipped</button>
                                            @endif
                                        </div>
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
                                    </div>
                                    @if ($item->shipment_status == 'delivered' || $item->shipment_status == 'shipped')
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong>
                                        {{ $item->shippment_company ?? '' }}
                                    </p>
                                    <p><strong>Shipment Tracking Number:</strong>
                                        {{ $item->tracking_number ?? '' }}
                                    </p>
                                    @else
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong> .......</p>
                                    <p><strong>Shipment Tracking Number:</strong> .......</p>
                                    @endif
                                </div>
                                <div style="border-right: 1px solid #ddd" class="col-md-3 d-flex flex-column justify-content-center">
                                    <button
                                        data-name="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"
                                        data-email="{{ Auth::user()->email ?? '' }}"
                                        data-phone="{{ Auth::user()->phone ?? '' }}"
                                        data-title="Buyer Contact Info" type="button"
                                        class="btn btn-primary btn-sm contact-btn">
                                        Buyer Contact
                                    </button>

                                </div>
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
<!-- Shipping Modal -->
<div class="modal fade" id="shippingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="shippingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="shippingModalLabel">Enter Shipping Details</h5>
                <span style="cursor: pointer;" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fs-3">&times;</span>
                </span>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="shippingCompany" class="form-label">Shipping Company</label>
                    <input type="text" class="form-control" id="shippingCompany"
                        placeholder="Enter company name">
                </div>
                <div class="form-group">
                    <label for="trackingNumber" class="form-label">Tracking Number</label>
                    <input type="text" class="form-control" id="trackingNumber"
                        placeholder="Enter tracking number">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveShipmentDetails">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Buyer Contact Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="buyerName"></span></p>
                <p><strong>Email:</strong> <span id="buyerEmail"></span></p>
                <p><strong>Phone:</strong> <span id="buyerPhone"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('seller-custome-js')
<script>
    $(document).ready(function() {
        $(".contact-btn").on("click", function() {
            let name = $(this).data("name");
            let email = $(this).data("email");
            let phone = $(this).data("phone");
            let title = $(this).data("title");

            $("#contactModalLabel").text(title);
            $("#buyerName").text(name);
            $("#buyerEmail").text(email);
            $("#buyerPhone").text(phone);

            $("#contactModal").modal("show");
        });
    });
</script>
<script>
    function changePayment(id, status) {
        let paymentStatus = status;
        let orderItemId = id;
        $.ajax({
            url: '{{ route("seller.update.order-item.status") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order_item_id: orderItemId,
                col: "payment_status",
                value: paymentStatus
            },
            success: function(response) {
                toastr.success(response.message);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    };

    function changeShipemnt(id, status) {
        let paymentStatus = status;
        let orderItemId = id;
        if (paymentStatus === 'shipped') {
            $('#shippingModal').data('order-item-id', orderItemId).modal('show');
        } else {
            $.ajax({
                url: '{{ route("seller.update.order-item.status") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_item_id: orderItemId,
                    col: "shipment_status",
                    value: paymentStatus
                },
                success: function(response) {
                    toastr.success(response.message);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    }

    // Handle modal form submission
    $('#saveShipmentDetails').on('click', function() {
        let orderItemId = $('#shippingModal').data('order-item-id');
        let companyName = $('#shippingCompany').val();
        let trackingNumber = $('#trackingNumber').val();

        if (companyName.trim() === '' || trackingNumber.trim() === '') {
            alert('Please fill in all fields.');
            return;
        }

        $.ajax({
            url: '{{ route("seller.update.order-item.status") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order_item_id: orderItemId,
                col: "shipment_status",
                value: "shipped",
                shipping_company: companyName,
                tracking_number: trackingNumber
            },
            success: function(response) {
                toastr.success(response.message);
                $('#shippingModal').modal('hide');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
</script>
@endsection