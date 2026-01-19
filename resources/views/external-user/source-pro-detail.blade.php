@extends('external-user.external-frame')
@section('meta_data')
<title>{{ $quotation->product_service ?? '' }}</title>
<meta name="description"
    content="Bid on our {{ $quotation->product_service ?? '' }} on World Business Guide - WBG24.com – Your international Market.">
<meta name="keywords" content="{{ $quotation->product_service ?? '' }}">
<meta name="author" content="WBG24.com">
@endsection


@section('external-main-content')
<!-- product listing here -->
<section class="container-fluid">

    <div class="row">
        <nav aria-label="breadcrumb" class="mb-2 mt-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" onclick="window.history.go(-1); return false;">Back</a></li>
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/source-pro">Source Pro</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $quotation->product_service }}
                </li>
            </ol>
        </nav>

        <div class="col-xl-12 ">
            <div class="card rounded-0 border-0">
                <div class="row">
                    <div class="col-md-5" style="border: 1px solid #ddd">
                        <div class="card border-0 rounded-0">
                            <div class="card-body img_view">
                                <img class="large-view rounded-2 img-fluid"
                                    src="@if (isset($quotation->image_1) && $quotation->image_1 != '') {{ asset('uploads/quotation/' . $quotation->image_1) }} @else https://placehold.co/400 @endif"
                                    alt="" />
                            </div>
                            <hr />
                            <div class="card-footer border-0 d-flex bg-white">
                                @if (isset($quotation->image_1) && $quotation->image_1 != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/quotation/' . $quotation->image_1) }}"
                                        alt="" />
                                </div>
                                @endif
                                @if (isset($quotation->image_2) && $quotation->image_2 != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/quotation/' . $quotation->image_2) }}"
                                        alt="" />
                                </div>
                                @endif
                                @if (isset($quotation->image_3) && $quotation->image_3 != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/quotation/' . $quotation->image_3) }}"
                                        alt="" />
                                </div>
                                @endif
                                @if (isset($quotation->image_4) && $quotation->image_4 != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/quotation/' . $quotation->image_4) }}"
                                        alt="" />
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 product_details_single">
                        <h1 class="product_title mx-2 fs-5 fw-bolder mt-3">
                            {{ $quotation->product_service }}
                        </h1>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mx-2 mt-2 d-block fw-bolder">WBG24 Item Number : <span class="text-secondary">Q{{ str_pad($quotation->id, 9, '0', STR_PAD_LEFT) }}</span></p>
                                <p class="mx-2 mt-2 d-block fw-bolder">Date posted : <span class="text-secondary">{{ date('d M Y | H:i', strtotime($quotation->created_at)) }}</span></p>
                                <p class="mx-2 mt-2 d-block fw-bolder">Expired On : <span class="text-secondary">{{ $quotation->expiry_date ?? '' }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mx-2 mt-2 d-flex align-items-center">
                                    Posted In:
                                    <img height="20" class="mx-2"
                                        src="https://flagcdn.com/160x120/{{ strtolower($quotation->country->iso2) }}.png"
                                        alt="" />{{ $quotation->country->name ?? '' }}
                                </p>
                                <p class="mx-2 mt-2 d-block fw-bolder">From : <span class="text-secondary">{{ $quotation->vendor->first_name ?? '' }}</span></p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="mx-2 fw-semibold fs-6">
                                Required Quantity: <span class="text-secondary">{{ $quotation->quantity }}</span>
                            </h5>
                            <h5 class="mt-2 mx-2 fw-semibold fs-6">Required Price: <span class="text-secondary">US$ {{$quotation->price}}</span></h5>
                        </div>
                        <div class="mt-5" style="border: 1px solid #202020">
                        </div>
                        <form method="post" id="sendOrder" class="d-flex mt-5 flex-wrap">
                            <div class="input-group">
                                <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                                <input type="text" name="offer_price" placeholder="Enter your price"
                                    class="form-control">
                                <button type="submit" class="input-group-btn btn btn-primary">Send Quote</button>
                            </div>
                        </form>
                        <!--<a class="btn btn-secondary mt-5"  href="{{route('seller.profile.view', $quotation->vendor->ref_no)}}">Request to Buyer</a>-->
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="my-5" style="min-height: 7rem; border: 1px solid #202020">
                            <h5 class="fw-bold pt-3 mx-2">Description:</h5>
                            <p class="mx-2 mt-2 d-block">{{ $quotation->requirement_details }}</p>
                        </div>
                        <div class="card mb-3 rounded-0">
                            <div class="card-header rounded-0 bg-body-secondary">
                                <h5 class="py-2 fw-semibold">Contact Us</h5>
                            </div>
                            <form method="post" action="{{ route('send.contact.form') }}" id="contact_form"
                                class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="receiver_id" value="{{ $quotation->user_id }}">
                                        <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
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
        </div>
    </div>

</section>
@include('external-user.inc-parts.listCard')

<div class="container-fluid my-3">
    <a href="{{ url()->previous() }}" class="btn btn-primary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>
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
                url: '{{ route("offer.quotation") }}',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        submitButton.prop('disabled', false).text('Send Quote');
                        window.location.href = response?.url;
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
                        submitButton.prop('disabled', false).text('Send Quote');
                    }
                },
                error: function(xhr) {
                    let error = xhr.responseJSON.message;
                    toastr.error(error);
                },
                complete: function() {
                    submitButton.prop('disabled', false).text('Send Quote');
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