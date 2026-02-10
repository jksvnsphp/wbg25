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

    #stars i {
        cursor: pointer;
        color: #ccc;
    }

    #stars .fa-solid {
        color: #FF7519;
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
                    My Purchased Product Details
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
                                <table class="table table-striped table-bordered">
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
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    {{ $item->quantity }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold mb-2" style="color: #FF7519;">Purchased On : </div>
                                                <div class="fw-bold" style="color: #2E2B70;">
                                                    {{ date('d.M.y', strtotime($item->created_at)) }}
                                                </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    CET {{ date('h:i A', strtotime($item->created_at)) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold mb-2" style="color: #FF7519;">Buying Price : </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    USD {{ number_format($item->total_price) }}
                                                </div>
                                                                                                <div class="fw-bold mb-2" style="color: #FF7519;">Shipping Cost : </div>
                                                <div class="fw-bold mb-2" style="color: #2E2B70;">
                                                    USD {{ number_format($item->order->shipping_cost) }}
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

                            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5">
                                <div class="col" style="border-right: 1px solid #ddd">
                                    <h6 class="fw-bold mb-3">Payment method</h6>
                                    @php
                                    $payment_infos = $item->product->vendor->payment_infos ?? [];
                                    @endphp

                                    <div class="row">
                                        <p>Please Transfer the product amount of @if ($item->product->currency0 == 'USD')
                                            USD &dollar; {{ $item->total_price + $item->order->shipping_cost ?? 0 }}
                                            @else
                                            EURO &euro; {{ $item->total_price + $item->order->shipping_cost ?? 0 }}
                                            @endif</p>
                                        <h5>To:</h5>
                                        @foreach ($payment_infos as $bankDetails)
                                        @if ($bankDetails->isPayPal)
                                        <div class="col-md-12">
                                            <div class="card  border-0 shadow-0">
                                                <div class="card-body py-1 px-1">
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
                                        <div class="col-md-12">
                                            <div class="card  border-0 shadow-0">
                                                <div class="card-body py-1 px-1">
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
                                        <div class="col-md-12">
                                            <div class="card  border-0 shadow-0">
                                                <div class="card-body py-1 px-1">
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
                                        <div class="col-md-12">
                                            <div class="card  border-0 shadow-0">
                                                <div class="card-body py-1 px-1">
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


                                </div>

                                <div style="border-right: 1px solid #ddd" class="col d-flex flex-column justify-content-start">
                                    <h6 class="fw-bold mb-3">Supplier Details</h6>
                                    <div> {{$item->product->vendor->first_name ?? ''}} {{$item->product->vendor->last_name ?? ''}} </div>
                                    @if($item->product->vendor->street != null || $item->product->vendor->house_no != null)
                                    <div> {{$item->product->vendor->street ?? ''}} {{$item->product->vendor->house_no ?? ''}} </div>
                                    @endif
                                    <div> {{$item->product->vendor->city ?? ''}} </div>
                                    <div> {{$item->product->vendor->stateData->name ?? 'ss'}}, {{$item->product->vendor->countryData->name ?? 'ss'}} </div>
                                    <div> {{$item->product->vendor->zip ?? ''}} </div>
                                </div>

                                <div style="border-right: 1px solid #ddd" class="col d-flex flex-column justify-content-start">
                                    <h6 class="fw-bold mb-3">Payment Details</h6>

                                    <p>
                                        @if ($item->payment_status == 'pending')
                                        <span class="badge rounded-0 p-2 bg-primary">Not yet paid</span>
                                        @elseif ($item->payment_status == 'failed')
                                        <span class="badge rounded-0 p-2 bg-danger">Failed</span>
                                        @elseif ($item->payment_status == 'cancelled')
                                        <span class="badge rounded-0 p-2 bg-danger">Cancelled</span>
                                        @elseif ($item->payment_status == 'paid')
                                        <span class="badge rounded-0 p-2 bg-success">Paid</span>
                                        @else
                                        <span class="badge rounded-0 p-2 bg-dark">No Status Found</span>
                                        @endif
                                    </p>
                                </div>

                                <div style="border-right: 1px solid #ddd" class="col d-flex flex-column justify-content-center">
                                    <h6 class="fw-bold mb-3">Shipment Details</h6>

                                    <p>
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
                                    </p>
                                    @if ($item->shipment_status == 'delivered' || $item->shipment_status == 'shipped')
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong> {{ $item->shippment_company ?? '' }}</p>
                                    <p><strong>Shipment Tracking Number:</strong> {{ $item->tracking_number ?? '' }}</p>
                                    @else
                                    <p class="mt-3 d-block"><strong>Shipment Company:</strong> .......</p>
                                    <p><strong>Shipment Tracking Number:</strong> .......</p>
                                    @endif
                                </div>

                                <div class="col flex-column d-flex justify-content-center align-items-center">

                                    <a data-bs-toggle="modal" data-bs-target="#contactseller" href="javaScript:void(0)"
                                        class="btn btn-primary mt-4">
                                        Contact Seller
                                    </a>
                                    <button type="button" class="btn btn-secondary mt-4 px-4" data-bs-toggle="modal"
                                        data-bs-target="#rateModal">
                                        Rate Seller
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
                            <input type="hidden" name="receiver_id" value="{{ $item->product->vendor_id ?? null }}">
                            <input type="hidden" name="product_id" value="{{ $item->product->id ?? null }}">
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
<!-- Rate Modal -->
<div class="modal fade" id="rateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="rateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rateModalLabel">Rate Your Buy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rateForm" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="vendor_id" value="{{ $item->product->vendor_id ?? null }}">
                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                    <input type="hidden" name="order_id" value="{{ $item->order_id }}">
                    <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                    <input type="hidden" name="rate" id="rateValue" value="{{ $item->rate->rate ?? '' }}">

                    <div class="d-flex justify-content-center mb-5">
                        <div id="stars" class="stars" style="font-size: 2rem;">
                            <i class="fa-regular fa-star" data-value="1"></i>
                            <i class="fa-regular fa-star" data-value="2"></i>
                            <i class="fa-regular fa-star" data-value="3"></i>
                            <i class="fa-regular fa-star" data-value="4"></i>
                            <i class="fa-regular fa-star" data-value="5"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-secondary me-3">Rate</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Later</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('seller-custome-js')
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
                url: "{{ route('send.contact.product.form') }}",
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
<script>
    $(document).ready(function() {
        let selectedRating = $('#rateValue').val() || 0;

        function highlightStars(rating) {
            $('#stars i').each(function(index) {
                $(this).toggleClass('fa-solid', index < rating);
                $(this).toggleClass('fa-regular', index >= rating);
            });
        }
        highlightStars(selectedRating);
        // Handle hover effect
        $('#stars i').on('mouseover', function() {
            const value = $(this).data('value');
            highlightStars(value);
        });
        $('#stars i').on('mouseout', function() {
            highlightStars(selectedRating);
        });
        $('#stars i').on('click', function() {
            selectedRating = $(this).data('value');
            $('#rateValue').val(selectedRating);
        });

        // Handle form submission
        $('#rateForm').on('submit', function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            $.ajax({
                url: '{{ route("buyer.set.rate") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    toastr.success('Rating saved successfully!');
                    $('#rateModal').modal('hide');
                },
                error: function() {
                    toastr.error(
                        'There was an error saving your rating. Please try again.');
                },
            });
        });
    });
</script>
@endsection