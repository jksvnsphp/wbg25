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
                                <h4 class="fw-bold fs-5">Forget Password</h4>
                            </div>
                            <div class="card-body p-4 pb-0 pt-2">
                                <form action="" id="sendotp" method="post"
                                    class="h-100 w-100 d-flex align-items-center justify-content-center">
                                    @csrf
                                    <div class="row w-100">
                                        <div class="col-md-12">

                                            <div class="form-group mb-4 d-flex flex-column">
                                                <label for="email" class="form-label fw-bolder">Your Registered eMail
                                                    Id<span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Enter your Registered eMail Id.." id="email" />
                                            </div>
                                            <div class="my-4 mb-0">
                                                <button id="sendotpbtn" type="submit" class="btn me-3 btn-primary">
                                                    Send Code
                                                </button>

                                            </div>
                                            <span data-bs-toggle="modal" data-bs-target="#forgetotp" class="d-none"
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
    <div class="modal fade" id="forgetotp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="registerotpLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-6" id="registerotpLabel">
                        Verify with Code
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
                            <button type="button" class="btn btn-primary my-4" onclick="validateOTP()">
                                Validate Code
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changepassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="registerotpLabel" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-6" id="registerotpLabel">
                        Change Your Password
                    </h1>
                    <i class="fa-solid fa-xmark text-secondary pointer-event" data-bs-dismiss="modal" aria-label="Close"
                        style="cursor: pointer !important;"></i>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="changePasswordForm" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="text" class="form-control" id="newPassword" name="newPassword" placeholder="Enter your new password" required />
                            </div>
                            <div class="form-group mt-4">
                               <button class="btn btn-primary" id="changePasswordFormbtn" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
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

            var otp1 = document.getElementById("otp1").value;
            var otp2 = document.getElementById("otp2").value;
            var otp3 = document.getElementById("otp3").value;
            var otp4 = document.getElementById("otp4").value;
            var otp5 = document.getElementById("otp5").value;
            // Concatenate the OTP
            var otp = otp1 + otp2 + otp3 + otp4 + otp5;
            $.ajax({
                url: "{{ route('forget.verify.otp') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    otp: otp
                },
                success: function(response) {
                    // console.log(response);
                    if (response.success == true) {
                        toastr.success(response.message)
                        $('#forgetotp').modal('hide');
                        $('#changepassword').modal('show');
                    } else {
                        toastr.error(response.message)

                    }
                }
            });

        }
    </script>
    <script>
        $(document).ready(function() {
            $('#sendotp').submit(function(e) {
                e.preventDefault();

                var sendotpbtn = $('#sendotpbtn');
                var originalText = sendotpbtn.text(); // Store the original button text
                var formData = new FormData($('#sendotp')[0]);

                // Disable the button and show "OTP Sending..." text
                sendotpbtn.prop('disabled', true).text('Code Sending...');

                $.ajax({
                    url: "{{ route('forget.send.otp') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success == true) {
                            $('#openOtppopup').click();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong. Please try again.');
                    },
                    complete: function() {
                        // Re-enable the button and restore the original text
                        sendotpbtn.prop('disabled', false).text(originalText);
                    }
                });
            });
        });
        
    </script>
    <script>
        $(document).ready(function() {
            $('#changePasswordForm').submit(function(e) {
                e.preventDefault();

                var changePasswordFormbtn = $('#changePasswordFormbtn');
                var originalText = changePasswordFormbtn.text(); 
                var formData = new FormData($('#changePasswordForm')[0]);
                changePasswordFormbtn.prop('disabled', true).text('Updating...');

                $.ajax({
                    url: "{{ route('forget.update.password') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success(response.message);
                            location.href=response.url;
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong. Please try again.');
                    },
                    complete: function() {
                        changePasswordFormbtn.prop('disabled', false).text(originalText);
                    }
                });
            });
        });
    </script>
@endsection
