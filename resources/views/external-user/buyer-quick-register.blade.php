@extends('external-user.external-frame')

@section('external-main-content')
<style>
    .otp-input {
        width: 3em;
        height: 3em;
        margin: 0 0.2em;
        padding: 0.5em;
        text-align: center;
        border: 1px solid #ddd;
    }

    .otp-input:focus {
        outline: none !important;
        border: 1px solid #ddd;
    }

    .otp-input:valid {
        border: 1px solid #03c003 !important;
    }
</style>
<section class="container-fluid py-3">
    <div class="row justify-content-center">
        <div class="col-md-11 login_forma">
            <div class="row my-3 justify-content-end">
                <div class="col-md-6 mt-3 buyer_rg">
                    <div class="card shadow rounded-0" style="height: 23rem">
                        <div class="card-header py-3">
                            <h4 class="fw-bold fs-5">Buyer Registration for free</h4>
                        </div>
                        <div class="card-body p-4 pb-0 pt-2">
                            <form id="sendotp" method="post"
                                class="h-100 w-100 d-flex align-items-center justify-content-center">
                                @csrf
                                <div class="row w-100">
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label fw-bolder">Your Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter your first name.."
                                                name="first_name" />
                                        </div>
                                        <div class="form-group mb-4 d-flex flex-column">
                                            <label for="email" class="form-label fw-bolder">Your Email Address<span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Enter your email address.." id="email" />
                                        </div>
                                        <div class="my-4 mb-0">
                                            <button id="sendotpbtn" type="submit" class="btn me-3 btn-primary">
                                                Register Now
                                            </button>

                                        </div>
                                        <span data-bs-toggle="modal" data-bs-target="#registerotp" class="d-none"
                                            id="openOtppopup"></span>
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

<!-- Modal -->
<div class="modal fade" id="registerotp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="registerotpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-6" id="registerotpLabel">
                    Verify with the code
                </h1>
                <i class="fa-solid fa-xmark text-secondary pointer-event" data-bs-dismiss="modal" aria-label="Close"
                    style="cursor: pointer !important;"></i>
            </div>
            <div class="modal-body">
                <form id="otpForm">
                    <div class="d-flex justify-content-center mt-4">
                        <input type="text" class="otp-input" id="otp1" maxlength="1"
                            oninput="moveToNext(this, 'otp2')" required />
                        <input type="text" class="otp-input" id="otp2" maxlength="1"
                            oninput="moveToNext(this, 'otp3')" required />
                        <input type="text" class="otp-input" id="otp3" maxlength="1"
                            oninput="moveToNext(this, 'otp4')" required />
                        <input type="text" class="otp-input" id="otp4" maxlength="1"
                            oninput="moveToNext(this, 'otp5')" required />
                        <input type="text" class="otp-input" id="otp5" maxlength="1"
                            oninput="moveToNext(this, null)" required />
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <small class="text-success text-center py-2">Please verify with the code which we have send out via email.</small>
                        <button type="button" class="btn btn-primary my-4" onclick="validateOTP()">
                            Validate Code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection
@section('custom-js-external')
<script>
    function moveToNext(currentInput, nextInputId) {

        var maxLength = parseInt(currentInput.getAttribute("maxlength"));
        var currentLength = currentInput.value.length;

        if (currentLength >= maxLength) {
            if (nextInputId) {
                document.getElementById(nextInputId).focus();
            }
        }
    }

    function validateOTP() {
        // alert('ues');
        // Get values from input boxes
        var otp1 = document.getElementById("otp1").value;
        var otp2 = document.getElementById("otp2").value;
        var otp3 = document.getElementById("otp3").value;
        var otp4 = document.getElementById("otp4").value;
        var otp5 = document.getElementById("otp5").value;

        // Concatenate the OTP
        var otp = otp1 + otp2 + otp3 + otp4 + otp5;

        // Perform validation (you can replace this with your own validation logic)
        if (otp && otp.length == 5) {
            $.ajax({
                url: "{{ route('buyer.verify.otp') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    otp: otp
                },
                success: function(response) {
                    // console.log(response);
                    if (response.status == true) {
                        location.href = response.url;
                    } else {
                        toastr.error(response.message)

                    }
                }
            });
        } else {
            alert("Invalid Code. Please try again.");
        }
    }
</script>
<script>
    $(document).ready(function() {

        $('#sendotp').submit(function(e) {
            e.preventDefault();
            var formData = new FormData($('#sendotp')[0]);

            $.ajax({
                url: "{{ route('buyer.send.otp') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == true) {
                        $('#openOtppopup').click();
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });


    });
</script>
{{-- <script>
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
    </script> --}}
@endsection