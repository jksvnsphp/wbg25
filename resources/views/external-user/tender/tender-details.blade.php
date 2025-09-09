@extends('external-user.external-frame')
@section('meta_data')
    <title> {{ $tender->name ?? '' }}</title>
    <meta name="description"
        content="Bid on our {{ $tender->name ?? '' }} on World Business Guide - WBG24.com – Your international Market.">
    <meta name="keywords" content="{{ $tender->name ?? '' }}">
    <meta name="author" content="WBG24.com">
@endsection
@section('external-main-content')
    <!-- product listing here -->
    <section class="container-fluid">

        <div class="row">
            <div class="col-4 py-4 ">
                <p class="mb-0 pb-0 ">Home > Tenders {!! $tender->searched_path !!}</p>
            </div>
             <div class="col-4 py-4 ">
                <h5 class="mt-2 fs-6">Posted Date: <span class="text-secondary">{{ $tender->added_at ?? '' }}</span></h5>
            </div>
             <div class="col-4 py-4 ">
              <h5 class="mt-2 fs-6">Expired On: <span class="text-secondary">{{ $tender->expiry_date ?? '' }}</span></h5>
            </div>
            <div class="col-12">
                <h5 class="fw-semibold fs-5 py-2 mt-2 ">
                    {{ $tender->name }}
                </h5>
            </div>
            <div class="col-xl-7">
                <div class="row list_title">
                    <div class="col-xl-6">
                        <div class="d-flex align-items-center mb-1 mt-3 ">
                            <small class="me-2">TN-{{ str_pad($tender->id, 6, '0', STR_PAD_LEFT) }} |</small>
                            <small class="p-1 py-0 bg-secondary rounded-3 text-light me-2">
                                {{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $tender->tender_condition) }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="card mb-3 rounded-0">
                            <div class="card border-0 rounded-0">
                                <div class="card-body img_view">
                                    <img class="large-view rounded-2 img-fluid"
                                        src="@if (isset($tender->image_1) && $tender->image_1 != '') {{ asset('uploads/tender/' . $tender->image_1) }} @else https://placehold.co/400 @endif"
                                        alt="" />
                                </div>
                                <hr />
                                <div class="card-footer border-0 d-flex bg-white">
                                    @if (isset($tender->image_1) && $tender->image_1 != '')
                                        <div class="in-img">
                                            <img class="small-view" src="{{ asset('uploads/tender/' . $tender->image_1) }}"
                                                alt="" />
                                        </div>
                                    @endif
                                    @if (isset($tender->image_2) && $tender->image_2 != '')
                                        <div class="in-img">
                                            <img class="small-view" src="{{ asset('uploads/tender/' . $tender->image_2) }}"
                                                alt="" />
                                        </div>
                                    @endif
                                    @if (isset($tender->image_3) && $tender->image_3 != '')
                                        <div class="in-img">
                                            <img class="small-view" src="{{ asset('uploads/tender/' . $tender->image_3) }}"
                                                alt="" />
                                        </div>
                                    @endif
                                    @if (isset($tender->image_4) && $tender->image_4 != '')
                                        <div class="in-img">
                                            <img class="small-view" src="{{ asset('uploads/tender/' . $tender->image_4) }}"
                                                alt="" />
                                        </div>
                                    @endif
                                    @if (isset($tender->image_5) && $tender->image_5 != '')
                                        <div class="in-img">
                                            <img class="small-view" src="{{ asset('uploads/tender/' . $tender->image_5) }}"
                                                alt="" />
                                        </div>
                                    @endif
                                    @if (isset($tender->image_6) && $tender->image_6 != '')
                                        <div class="in-img">
                                            <img class="small-view" src="{{ asset('uploads/tender/' . $tender->image_6) }}"
                                                alt="" />
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <h5 class="mt-2 fs-6">Offered Quantity: <span class="text-secondary">{{$tender->quantity ?? 0}}</span></h5>
                                        <h5 class="mt-2 fs-6">Required Price: <span class="text-secondary">{{$tender->currency=="usd"?"US$":"EURO"}}{{$tender->price ?? 0}}</span> </h5>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- <h5 class="mt-2 fs-6">Expired On: <span class="text-secondary">{{ $tender->expiry_date ?? '' }}</span></h5> -->
                                    </div>
                                </div>
                            </div>
                            <form method="post" id="sendOrder" class="col-md-6">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                                    <input type="text" name="offer_price" placeholder="Enter your prices"
                                        class="form-control" />
                                    <button type="submit" class="btn btn-primary input-group-btn">
                                        Send Price Offer
                                    </button>
                                </div>
                            </form>
                            <div class="col-md-6 text-end">
                                <button id="directOrder" class="btn btn-secondary" type="button"
                                    data-id="{{ $tender->id }}">Accept Price and Trade</button>
                            </div>
                        </div>
                        <div class="card mb-3 rounded-0">
                            <div class="card-body">
                                <h5 class="fw-bold fs-6">Description</h5>
                                <p class="fs-6 mt-2" style="line-height: 1.5">
                                    {!! $tender->description !!}
                                </p>
                            </div>
                        </div>
                        <div class="card mb-3 rounded-0">
                            <div class="card-header rounded-0 bg-body-secondary">
                                <h5 class="py-2 pb-1 fw-semibold">Contact</h5>
                            </div>
                            <form method="post" action="{{ route('send.contact.form') }}" id="contact_form"
                                class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="receiver_id" value="{{ $tender->vendor_id }}">
                                        <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                                        <div class="form-group mb-2">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name') }}" />
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-2">
                                            <label for="subject" class="form-label">Subject:</label>
                                            <input type="text" name="subject" class="form-control"
                                                value="{{ old('subject') }}" />
                                            @error('subject')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-2">
                                            <label for="message" class="form-label">Message:</label>
                                            <textarea name="message" id="message" class="form-control">{{ old('message') }}</textarea>
                                            @error('message')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-group d-flex flex-column mb-3">
                                            <label for="image" class="form-label">Verification Code:</label>
                                            <div class="d-flex align-items-center">
                                                {!! captcha_img('flat', ['id' => 'captcha_img']) !!}

                                                <i class="fa-solid fa-rotate mx-3  " onclick="refreshCaptcha()"
                                                    style="cursor: pointer !important"></i>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-group mb-3">
                                            <label for="ver_box" class="form-label">Enter Verification Code in below
                                                box:</label>
                                            <input type="text" value="{{ old('captcha') }}" class="form-control"
                                                name="captcha" id="captcha" />
                                            @error('captcha')
                                                <p class="text-danger pt-3"> {{ $message }} </p>
                                            @enderror
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
           <div class="col-xl-3 my-4">
                <div class="card rounded-0 mt-3">
                    <div class="card-header rounded-0 d-flex justify-content-between">
                        <h5 class="fw-bold">
                            {{ isset($tender->vendor->company->name) ? $tender->vendor->company->name : '' }}</h5>
                        <div>
                            <div class="rating_company d-flex  my-2">
                                @php

                                    $rating = $seller->rating ?? 0;
                                    $fullStars = floor($rating);
                                    $emptyStars = 5 - $fullStars;
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star text-secondary"></i>
                                @endfor
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="fas fa-star " style="color:gray;"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-1">
                        <div class="d-flex justify-content-between">
                            <p class="px-0 mx-0 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('world-business/images/badge-removebg-preview.png') }}" alt=""
                                    style="height: 18px; margin-left:-5px;" /> First Year
                            </p>
                        </div>
                        <div>
                            <p class="mt-3" style="font-size: 14px !important">
                                <strong class="fw-bold"><i class="fa-solid fa-business-time"></i> Member Since:</strong>
                                {{ isset($tender->vendor->company->updated_at) ? date('M, Y', strtotime($tender->vendor->company->updated_at)) : 'N/A' }}

                            </p>

                            <p class="mt-3 d-flex" style="font-size: 14px !important">
                                <strong class="fw-bold me-2"><i class="fa-solid fa-location-dot"></i></strong>
                                {{ isset($tender->vendor->street) ? $tender->vendor->street . ', ' : '' }}
                                {{ isset($tender->vendor->house_no) ? $tender->vendor->house_no . ', ' : '' }}
                                {{ isset($tender->vendor->city) ? $tender->vendor->city : '' }},{{ isset($tender->state->name) ? $tender->state->name : '' }},{{ isset($tender->country->name) ? $tender->country->name : '' }}
                                {{ isset($tender->vendor->zip) ? $tender->vendor->zip : '' }}
                            </p>


                            <p class="px-0 mb-2 mx-0 mt-3 d-flex justify-content-start align-items-center">
                                <strong class="fw-bold me-2"><i class="fa-solid fa-globe"></i></strong>
                                <small
                                    class="me-3">{{ isset($tender->country->name) ? $tender->country->name : '' }}</small>
                                <img src="https://flagcdn.com/40x30/{{ strtolower($tender->country->iso2) }}.png"
                                    alt="" style="height: 1rem" />
                            </p>
                        </div>
                    </div>
                </div>
                <style>
                    .fontp {
                        font-size: 14px !important;
                    }
                </style>
                <div class="card send_msg_supplier mt-1">
                    <div class="card-body pb-0">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <p class="fw-bolder fontp">Shipping:</p>
                            </div>
                            <div class="col-md-8">
                                <p class="fontp">
                                    <strong
                                        class="fw-bolder">{{ isset($yourShippingCost['shipping_cost']) ? 'US$' . $yourShippingCost['shipping_cost'] : 'No Shipping Zone' }}
                                        WBG International shipping</strong>

                                </p>
                                <p class="text-muted" style="font-size: 12px">
                                    Located in:
                                   {{ isset($tender->vendor->city) ? $tender->vendor->city : '' }},{{ isset($tender->state->name) ? $tender->state->name : '' }},{{ isset($tender->country->name) ? $tender->country->name : '' }}
                                {{ isset($tender->vendor->zip) ? $tender->vendor->zip : '' }}
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <p class="fw-bolder fontp">Returns:</p>
                            </div>
                            <div class="col-md-8">
                                <p class="fontp">
                                    @if (isset($tender->isReturnAccept) && $tender->isReturnAccept == 1)
                                        <strong class="fw-semibold">{{ $tender->return_timeline }} Days
                                            returns.
                                            {{ $tender->seller_pay == 1 ? 'Seller pay for return shipping.' : 'Buyer pay for return shipping.' }}</strong>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="fw-bolder fontp">Payments:</p>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    @if (isset($tender->paymentInfo->isPayPal) && $tender->paymentInfo->isPayPal == 1)
                                        <div class="col-6 mb-2">
                                            <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                                <img src="{{ asset('world-business/images/icons/1156727_finance_payment_paypal_icon.png') }}"
                                                    style="  height: 100%; width: 100%;  object-fit: contain; object-position: center; "
                                                    alt="" />
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($tender->paymentInfo->isGooglePay) && $tender->paymentInfo->isGooglePay == 1)
                                        <div class="col-6 mb-2">
                                            <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                                <img src="{{ asset('world-business/images/icons/7123945_logo_pay_google_gpay_icon.png') }}"
                                                    style=" height: 100%; width: 100%; object-fit: contain; object-position: center; "
                                                    alt="" />
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($tender->paymentInfo->isBankDetail) && $tender->paymentInfo->isBankDetail == 1)
                                        <div class="col-6 mb-2">
                                            <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                                <img src="{{ asset('uploads/logo/bank.png') }}"
                                                    style=" height: 100%; width: 100%; object-fit: contain; object-position: center; "
                                                    alt="" />
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($tender->paymentInfo->isOther) && $tender->paymentInfo->isOther == 1)
                                        <div class="col-6 mb-2">
                                            <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                                <img src="{{ asset('apple-pay.png') }}"
                                                    style=" height: 100%; width: 100%; object-fit: contain; object-position: center; "
                                                    alt="" />
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </section>
    @include('external-user.inc-parts.listCard')
@endsection
@section('custom-js-external')
    <script>
        $(document).ready(function() {
            $(".small-view").on("click", function() {
                var newSrc = $(this).attr("src");
                $(".large-view").attr("src", newSrc);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Send Price Offer Form Submission
            $('#sendOrder').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true).text('Sending...');

                $.ajax({
                    url: '{{ route('offer.tender') }}',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            submitButton.prop('disabled', false).text('Send Price Offer');
                            window.location.href = response.url;

                        } else {
                            if (response?.code == "403") {
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
                            } else {
                                toastr.error(response.message);
                            }
                            submitButton.prop('disabled', false).text('Send Price Offer');
                        }
                    },
                    error: function(xhr) {
                        let error = xhr.responseJSON.message;
                        toastr.error(error);
                    },
                    complete: function() {
                        submitButton.prop('disabled', false).text('Send Price Offer');
                    }
                });
            });
            $('#directOrder').on('click', function() {
                let tenderId = $(this).data('id');
                let button = $(this);
                button.prop('disabled', true).text('Sending...');

                $.ajax({
                    url: '{{ route('accept.offer.tender') }}',
                    type: 'POST',
                    data: {
                        tender_id: tenderId
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            button.prop('disabled', false).text('Accept Price and Trade');
                            window.location.href = response.url;
                            
                        } else {
                            if (response?.code == "403") {
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
                            } else {
                                toastr.error(response.message);
                            }
                            button.prop('disabled', false).text('Accept Price and Trade');
                        }
                    },
                    error: function(xhr) {
                        let error = xhr.responseJSON.message;
                        toastr.error(error);
                    },
                    complete: function() {
                        button.prop('disabled', false).text('Accept Price and Trade');
                    }
                });
            });
        });
    </script>
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
@endsection
