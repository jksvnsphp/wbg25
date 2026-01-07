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
                    Quotation Details
                </h6>
            </div>

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
                                                    <img src="{{ asset('uploads/quotation/' . $quotation->image_1) }}"
                                                        style="height: 100%; width: 100%" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <p style="width: 10rem">
                                                    {{ $quotation->product_service ?? '' }}
                                                </p>
                                            </td>

                                            <td>
                                                <h6 class="text-center">
                                                    Deal Done
                                                    {{ date('d M, Y', strtotime($quotationOffer->created_at)) }}
                                                </h6>
                                                <h6 class="text-center">CET
                                                    {{ date('h:i A', strtotime($quotationOffer->created_at)) }}
                                                </h6>
                                            </td>
                                            <td>
                                                <span class="text-secondary fw-semibold">
                                                    Deal Price: USD&dollar; {{ $quotationOffer->offer_price ?? 0 }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $quotation->quantity ?? '' }} Sale Provision
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-bold fs-6 me-1">Status:</span>
                                                        <img src="{{ asset('world-business/images/vendor-ico/businessdeal.jpg') }}"
                                                            style="height: 4rem" alt="" />
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                {{ $quotation->requirement_details ?? '' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if ($quotationOffer->vendor_id == auth()->user()->id)
                            <div class="row mt-3">
                                <div class="col-md-4" style="border-right: 1px solid #ddd">
                                    <h6 class="fw-bold mb-3">Shipping Address</h6>
                                    @php
                                    $sender = $quotationOffer->sender ?? [];
                                    @endphp
                                    <p class="mb-0">{{ $sender->first_name . ' ' . $sender->last_name }}</p>
                                    @if (isset($quotationOffer->shipping_address))
                                    @php
                                    $shippingAddress = json_decode(
                                    $quotationOffer->shipping_address,
                                    true,
                                    );
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
                                    @else
                                    <p class="btn btn-danger disabled">Deal Not Closed Yet</p>
                                    @endif
                                </div>
                                <div style="border-right: 1px solid #ddd"
                                    class="col-md-4 d-flex flex-column justify-content-start">
                                    <h6 class="fw-bold mb-3">Payment Details</h6>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="form-group me-2" style="max-width: 10rem !important;">
                                            @if ($quotationOffer->payment_status == 'pending' || $quotationOffer->payment_status == 'failed')
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button"
                                                onclick="changePayment({{ $quotationOffer->id }},'paid')">Mark As
                                                Paid</button>
                                            @else
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button">Not Yet
                                                Paid</button>
                                            @endif
                                        </div>
                                        @if ($quotationOffer->payment_status == 'pending')
                                        <span class="badge rounded-0 bg-warning">Not yet paid</span>
                                        @elseif($quotationOffer->payment_status == 'failed')
                                        <span class="badge rounded-0 bg-danger">Failed</span>
                                        @elseif($quotationOffer->payment_status == 'cancelled')
                                        <span class="badge rounded-0 bg-secondary">Cancelled</span>
                                        @else
                                        <span class="badge rounded-0 bg-success">Paid</span>
                                        @endif
                                    </div>
                                </div>
                                <div style="border-right: 1px solid #ddd"
                                    class="col-md-4 d-flex flex-column justify-content-center">
                                    <h6 class="fw-bold mb-3">Shippment Details</h6>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <div class="form-group me-2" style="max-width: 12rem !important;">
                                            @if ($quotationOffer->shipment_status == 'pending' || $quotationOffer->shipment_status == 'cancelled')
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button"
                                                onclick="changeShipemnt({{ $quotationOffer->id }},'shipped')">Mark
                                                As
                                                Shipped</button>
                                            @else
                                            <button class="btn btn-light rounded-0" style="background: #ddd;"
                                                type="button"
                                                onclick="changeShipemnt({{ $quotationOffer->id }},'pending')">Not
                                                Yet
                                                Shipped</button>
                                            @endif
                                        </div>
                                        @if ($quotationOffer->shipment_status == 'pending')
                                        <span class="badge rounded-0 bg-warning">Not yet Shipped</span>
                                        @elseif($quotationOffer->shipment_status == 'failed')
                                        <span class="badge rounded-0 bg-secondary">Returned</span>
                                        @elseif($quotationOffer->shipment_status == 'cancelled')
                                        <span class="badge rounded-0 bg-danger">Cancelled</span>
                                        @elseif($quotationOffer->shipment_status == 'delivered')
                                        <span class="badge rounded-0 bg-success">Delivered</span>
                                        @else
                                        <span class="badge rounded-0 bg-success">Shipped</span>
                                        @endif
                                    </div>
                                    @if ($quotationOffer->shipment_status == 'delivered' || $quotationOffer->shipment_status == 'shipped')
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong>
                                        {{ $quotationOffer->shippment_company ?? '' }}
                                    </p>
                                    <p><strong>Shipment Tracking Number:</strong>
                                        {{ $quotationOffer->tracking_number ?? '' }}
                                    </p>
                                    @else
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong> .......</p>
                                    <p><strong>Shipment Tracking Number:</strong> .......</p>
                                    @endif
                                </div>

                            </div>
                            @else
                            <div class="row mt-3">
                                <div class="col-md-3" style="border-right: 1px solid #ddd">
                                    <h6 class="fw-bold mb-3">Payment method</h6>
                                    @php
                                    $payment_infos = $quotation->vendor->payment_infos ?? [];
                                    @endphp

                                    <div class="row">
                                        <p>Please Transfer the deal amount of @if ($quotation->currency == 'usd')
                                            USD &dollar; {{ $quotationOffer->offer_price ?? 0 }}
                                            @else
                                            EURO &euro; {{ $quotationOffer->offer_price ?? 0 }}
                                            @endif</p>
                                        <h5>To:</h5>
                                        @foreach ($payment_infos as $bankDetails)
                                        @if ($bankDetails->isPayPal)
                                        <div class="col-md-12 mb-3">
                                            <div class="card border-0 shadow-0">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <img src="{{ asset('uploads/logo/paypal.png') }}" style="height:1.5rem;" alt="PayPal">
                                                        PayPal
                                                    </h5>
                                                    <p class="card-text mb-0">Email: {{ $bankDetails->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($bankDetails->isGooglePay)
                                        <div class="col-md-12 mb-3">
                                            <div class="card border shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <img src="{{ asset('uploads/logo/gpay.png') }}" style="height:1.7rem;" alt="Google Pay">
                                                        Google Pay
                                                    </h5>
                                                    <p class="card-text mb-0">UPI ID: {{ $bankDetails->upi_google }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($bankDetails->isOther)
                                        <div class="col-md-12 mb-3">
                                            <div class="card border shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <img src="{{ asset('apple-pay.png') }}" style="height:1.7rem;" alt="Other Method">
                                                        {{ $bankDetails->other_method_name }}
                                                    </h5>
                                                    <p class="card-text mb-0">Details: {{ $bankDetails->other_value }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if ($bankDetails->isBankDetail)
                                        <div class="col-md-12 mb-3">
                                            <div class="card border shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        <img src="{{ asset('uploads/logo/bank.png') }}" style="height:1.7rem;" alt="Bank Transfer">
                                                        Instant Transfer
                                                    </h5>
                                                    <p class="card-text mb-1">Account Holder: {{ $bankDetails->account_holder }}</p>
                                                    <p class="card-text mb-1">Bank Name: {{ $bankDetails->bank_name }}</p>
                                                    <p class="card-text mb-1">IBAN: {{ $bankDetails->iban }}</p>
                                                    <p class="card-text mb-0">BIC: {{ $bankDetails->bic }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>

                                    @if($quotationOffer->isDealClose==0)
                                    <a href="" class="btn mt-3 btn-secondary rounded-0">Deal Close Now</a>
                                    @endif
                                </div>
                                <div style="border-right: 1px solid #ddd"
                                    class="col-md-3 d-flex flex-column justify-content-start">
                                    <h6 class="fw-bold mb-3">Payment Details</h6>

                                    <p>

                                        @if ($quotationOffer->payment_status == 'pending')
                                        <span class="badge rounded-0 p-2 bg-primary">Not yet paid</span>
                                        @elseif ($quotationOffer->payment_status == 'failed')
                                        <span class="badge rounded-0 p-2 bg-danger">Failed</span>
                                        @elseif ($quotationOffer->payment_status == 'cancelled')
                                        <span class="badge rounded-0 p-2 bg-danger">Cancelled</span>
                                        @elseif ($quotationOffer->payment_status == 'paid')
                                        <span class="badge rounded-0 p-2 bg-success">Paid</span>
                                        @else
                                        <span class="badge rounded-0 p-2 bg-dark">No Status Found</span>
                                        @endif
                                    </p>
                                </div>
                                <div style="border-right: 1px solid #ddd"
                                    class="col-md-3 d-flex flex-column justify-content-center">
                                    <h6 class="fw-bold mb-3">Shipment Details</h6>

                                    <p>

                                        @if ($quotationOffer->shipment_status == 'pending')
                                        <span class="badge rounded-0 bg-warning">Not yet Shipped</span>
                                        @elseif($quotationOffer->shipment_status == 'failed')
                                        <span class="badge rounded-0 bg-secondary">Returned</span>
                                        @elseif($quotationOffer->shipment_status == 'cancelled')
                                        <span class="badge rounded-0 bg-danger">Cancelled</span>
                                        @elseif($quotationOffer->shipment_status == 'delivered')
                                        <span class="badge rounded-0 bg-success">Delivered</span>
                                        @else
                                        <span class="badge rounded-0 bg-success">Shipped</span>
                                        @endif
                                    </p>
                                    @if ($quotationOffer->shipment_status == 'delivered' || $quotationOffer->shipment_status == 'shipped')
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong>
                                        {{ $quotationOffer->shippment_company ?? '' }}
                                    </p>
                                    <p><strong>Shipment Tracking Number:</strong>
                                        {{ $quotationOffer->tracking_number ?? '' }}
                                    </p>
                                    @else
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong> .......</p>
                                    <p><strong>Shipment Tracking Number:</strong> .......</p>
                                    @endif
                                </div>
                                <div class="col-md-3 flex-column d-flex justify-content-center align-items-center">

                                    <a data-bs-toggle="modal" data-bs-target="#contactseller"
                                        href="javaScript:void(0)" class="btn btn-primary mt-4">
                                        Contact Seller
                                    </a>

                                </div>
                            </div>
                            @endif

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


<div class="modal fade" id="contactseller" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Contact Seller</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="contact_form" class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="receiver_id" value="{{ $quotationOffer->vendor_id ?? null }}">
                            <input type="hidden" name="quotation_id" value="{{ $quotation->id ?? null }}">
                            <div class="form-group mb-2">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name') }}" />
                                <div id="name_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="subject" class="form-label">Subject:</label>
                                <input type="text" name="subject" class="form-control"
                                    value="{{ old('subject') }}" />
                                <div id="subject_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="message" class="form-label">Message:</label>
                                <textarea name="message" id="message" class="form-control">{{ old('message') }}</textarea>
                                <div id="message_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div class="form-group d-flex flex-column mb-3">
                                <label for="image" class="form-label">Verification Code:</label>
                                <div class="d-flex align-items-center">
                                    {!! captcha_img('flat', ['id' => 'captcha_img']) !!}
                                    <i class="fa-solid fa-rotate mx-3" onclick="refreshCaptcha()"
                                        style="cursor: pointer !important"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <div class="form-group mb-3">
                                <label for="ver_box" class="form-label">Enter Verification Code:</label>
                                <input type="text" value="{{ old('captcha') }}" class="form-control"
                                    name="captcha" id="captcha" />
                                <div id="captcha_error" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-secondary mt-3">Send</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
@section('seller-custome-js')
@if ($quotationOffer->vendor_id == auth()->user()->id)
<script>
    function changePayment(id, status) {
        let paymentStatus = status;
        let orderItemId = id;
        $.ajax({
            url: '{{ route("seller.status.deal-quotation") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                offer_id: orderItemId,
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
                url: '{{ route("seller.status.deal-quotation") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    offer_id: orderItemId,
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
            url: '{{ route("seller.status.deal-quotation") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                offer_id: orderItemId,
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
@else
<script>
    function refreshCaptcha() {
        $.ajax({
            type: 'GET',
            url: "{{ route('refreshCaptcha') }}",
            success: function(data) {
                $('#captcha_img').attr('src', data);
            },
            error: function() {
                alert('Error refreshing CAPTCHA. Please try again.');
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#contact_form').on('submit', function(e) {
            e.preventDefault();
            $('#name_error').text('');
            $('#subject_error').text('');
            $('#message_error').text('');
            $('#captcha_error').text('');
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('send.contact.form2') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $('#contact_form')[0].reset();
                        $('#contactseller').modal('hide');
                    } else if (response.status === 'error') {
                        $.each(response.errors, function(key, value) {
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else if (response.status === 'unauth') {
                        Swal.fire({
                            title: "<h5 class='fw-bolder fs-5'>To use this option you need to</h5>",
                            text: "",
                            icon: "",
                            draggable: true,
                            confirmButtonText: "Sign in",
                            confirmButtonColor: "#FF7519",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "{{ route('login') }}";
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error("An error occurred. Please try again.");
                }
            });
        });
    });
</script>
@endif
@endsection