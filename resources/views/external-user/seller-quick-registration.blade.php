@extends('external-user.external-frame')

@section('external-main-content')
    <section class="container-fluid py-3">
        <div class="row justify-content-center">
            <div class="col-md-11 login_forma">
                <div class="row my-3 justify-content-end">
                    <div class="col-md-6 mt-3 buyer_rg">
                        <div class="card shadow rounded-0" style="max-height: 29rem">
                            <div class="card-header py-3">
                                <h4 class="fw-bold fs-5">Seller Registration For (<small
                                        class="text-secondary fw-bold mb-0 pt-0 mt-0" style="font-size: 14px;">Join
                                        {{ $packageData->name }} : {{ $packageData->price ?? 0 }}€ </small>)</h4>
                            </div>
                            <div class="card-body p-4 pb-0 pt-2">
                                <form action="" id="sendotp" method="post"
                                    class="h-100 w-100 d-flex align-items-center justify-content-center">
                                    @csrf
                                    <div class="row w-100">
                                        <div class="col-md-12">
                                            <div class="form-group mb-4">
                                                <label for="name" class="form-label fw-bolder">Your Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter your first name.." id="name"
                                                    name="first_name" />
                                                <input type="hidden" name="package_code" id="package_code"
                                                    value="{{ $code }}">
                                            </div>
                                            <div class="form-group mb-4 d-flex flex-column ">
                                                <label for="tel" class="form-label fw-bolder">Your Phone Number<span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" class="form-control"
                                                    placeholder="Enter your phone number.." name="phone" id="mobile" />
                                                <input type="hidden" name="mobile" id="phone">
                                            </div>
                                            @if ($packageData->price > 0)
                                                <div class="form-group mb-4 d-flex flex-column ">
                                                    <label for="coupon_code" class="form-label fw-bolder">Promotion
                                                        Code</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter your promotion code" name="coupon_code"
                                                            id="coupon_code" />
                                                        <button type="button" onclick="applyCoupon()"
                                                            class="btn btn-primary input-group-btn ">Apply</button>
                                                    </div>
                                                    <small class="text-success mt-1 d-block" id="coupon-msg"></small>
                                                </div>
                                            @else
                                                <input type="hidden" name="coupon_code" id="coupon_code">
                                            @endif

                                            <div class="my-4 mb-3">
                                                <button id="sendotpbtn" type="submit" class="btn me-3 btn-primary">
                                                    Register Now
                                                </button>

                                            </div>

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

    <!-- login form section end  -->
@endsection
@section('custom-js-external')
    <script>
        $(document).ready(function() {
            $('#sendotpbtn').on('click', function(e) {
                e.preventDefault();
                var mobile = $('#phone').val();
                var name = $('#name').val();
                var coupon_code = $('#coupon_code').val();
                var token = "{{ csrf_token() }}";
                if (mobile == '') {
                    toastr.error('Please enter mobile number')
                    return false;
                }
                if (name == '') {
                    toastr.error('Please enter your name')
                    return false;
                }

                $.ajax({
                    url: "{{ route('seller.send.otp') }}",
                    type: 'POST',
                    data: {
                        _token: token,
                        phone: mobile,
                        name: name,
                        coupon_code: coupon_code
                    },
                    success: function(response) {
                        if (response?.status == true) {
                            var package_code = $('#package_code').val();
                            $.ajax({
                                url: "{{ route('seller.verify.otp') }}",
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    otp: "12345",
                                    package_code: package_code
                                },
                                success: function(response) {
                                    // console.log(response);
                                    if (response.status == true) {
                                        toastr.success(
                                            "Successfully complete your quick registration."
                                        )
                                        location.href = response?.url;
                                    } else {
                                        toastr.error(response.message)

                                    }
                                }
                            });
                        } else {
                            toastr.error(response?.message)
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })


            })
        });
    </script>
    <script>
        const codeinput = document.querySelector("#mobile");
        const iti = window.intlTelInput(codeinput, {
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.3.2/build/js/utils.js",
        });
        window.iti = iti;
        codeinput.addEventListener('input', function() {
            var dialCode = iti.getSelectedCountryData().dialCode;
            document.getElementById('phone').value = '+' + dialCode + ' ' + codeinput.value;

        });
    </script>

    <script>
        function applyCoupon() {
            let couponCode = $("#coupon_code").val();
            let couponMsg = $("#coupon-msg");

            if ($.trim(couponCode) === "") {
                couponMsg.text("Please enter a coupon code.").removeClass("text-success").addClass("text-danger");
                return;
            }

            $.ajax({
                url: "{{ route('apply.coupon') }}",
                type: "POST",
                data: {
                    code: couponCode,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        couponMsg.text("Coupon applied successfully! Discount: " + response.discount + "€")
                            .removeClass("text-danger")
                            .addClass("text-success");
                    } else {
                        couponMsg.text("Invalid or expired coupon.")
                            .removeClass("text-success")
                            .addClass("text-danger");
                    }
                },
                error: function() {
                    couponMsg.text("Something went wrong. Please try again.")
                        .removeClass("text-success")
                        .addClass("text-danger");
                }
            });
        }
    </script>
@endsection
