@extends('external-user.external-frame')
@section('external-main-content')
<style>
    .main_card_box .card {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        height: 100% !important;
    }

    .grouped_card {
        height: 15rem !important;
    }

    .main_card_box .rb_list li {
        line-height: 2 !important;
    }
</style>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 my-4">
                    <h6 class="fs-5" style="font-weight: 900 !important">
                        How can we Help you ?
                    </h6>
                </div>
                {{-- buyer articles --}}

                <a href="{{ route('howToBuy') }}" class="col-md-12 mt-5 grouped_card">
                    <div class="card h-100 rounded-0 border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-cart-shopping text-primary fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Buying on World Business Guide - WBG24.com</h5>
                        </div>
                    </div>
                </a>
                <div class="col-12">
                    <h6 class="fs-5 mt-4 mb-0" style="font-weight: 900 !important">
                        Help Articles For Buyer
                    </h6>
                </div>
                <a href="{{ route('productBuyerHelpArticles') }}" class="col-md-4 mt-3  grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-bullhorn fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Products</h5>
                        </div>
                    </div>
                </a>
                <a href="{{ route('tenderBuyerHelpArticles') }}" class="col-md-4 mt-3 grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-hammer  fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Tenders</h5>
                        </div>
                    </div>
                </a>
                <a href="{{ route('quotationBuyerHelpArticles') }}" class="col-md-4 mt-3 grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-right-left  fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Quotations</h5>
                        </div>
                    </div>
                </a>

                <a href="{{ route('howToSell') }}" class="col-md-12 mt-3 grouped_card">
                    <div class="card h-100 rounded-0 border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-tag text-primary fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Selling on World Business Guide - WBG24.com</h5>
                        </div>
                    </div>
                </a>
                <div class="col-12">
                    <h6 class="fs-5 mt-4 mb-0" style="font-weight: 900 !important">
                        Help Articles For Seller
                    </h6>
                </div>
                <a href="{{ route('businessHelpArticles') }}" class="col-md-4 mt-3  grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa-regular fa-user fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Business Profile</h5>
                        </div>
                    </div>
                </a>
                <a href="{{ route('spotlightStoreHelpArticles') }}" class="col-md-4 mt-3  grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-shop fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Spotlight Store</h5>
                        </div>
                    </div>
                </a>

                <a href="{{ route('productHelpArticles') }}" class="col-md-4 mt-3  grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-bullhorn fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Products</h5>
                        </div>
                    </div>
                </a>
                <a href="{{ route('tenderHelpArticles') }}" class="col-md-4 mt-3 grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-hammer  fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Tenders</h5>
                        </div>
                    </div>
                </a>
                <a href="{{ route('quotationHelpArticles') }}" class="col-md-4 mt-3 grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-right-left  fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Quotations</h5>
                        </div>
                    </div>
                </a>
                <a href="{{ route('saleCommissionHelpArticles') }}" class="col-md-4 mt-3 grouped_card">
                    <div class="card h-100 rounded-0 bg-primary border-0 shadow-lg">
                        <div class="card-body h-100 d-flex justify-content-center align-items-center flex-column">
                            <i class="fa fa-wallet  fs-1" aria-hidden="true"></i>
                            <h5 class="mt-3 fs-5 fw-semibold">Sale Commission</h5>
                        </div>
                    </div>
                </a>

            </div>
        </div>
        <div class="col-12 mt-4">
            <div
                class="py-3 w-100 card bg-secondary border-0 rounded-0 d-flex flex-row justify-content-center align-items-center flex-wrap">
                <h6 class="me-2" class="d-block">Get personalized help and contact our support</h6>
                <a data-bs-toggle="modal" data-bs-target="#contactseller" href="javaScript:void(0)"
                    class="btn btn-primary d-block">WBG24 Support</a>
            </div>
        </div>

    </div>
</section>
@include('external-user.inc-parts.listCard')
<div class="modal fade" id="contactseller" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Contact WBG24</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="contact_form" class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="receiver_id" value="5">
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
<div class="mt-3 px-3">
    <button type="button" onclick="window.history.back()" class="btn btn-primary text-light">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>
@endsection
@section('custom-js-external')
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
@endsection