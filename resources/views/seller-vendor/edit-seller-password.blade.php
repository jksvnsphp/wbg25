@extends('seller-vendor.seller-frame')
@section('seller-main-content')
<style>
    .otp-inputs {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .otp-box {
        width: 50px;
        text-align: center;
        font-size: 1.5rem;
    }

    .all-none {
        display: none;
    }
</style>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12  bg-primary py-3 pt-1 pb-5">
            <div class="d-flex">
                <h6 class="fs-5 text-light my-3 px-3 fw-bold">Change Passsword</h6>

            </div>

            <form method="post" id="editsellercompany" class="card rounded-0">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 position-relative">
                            <div class="form-group mb-3 d-flex flex-column">
                                <label for="current_password" class="form-label">Current Password<span class="text-danger fs-5">*</span></label>
                                <input type="password" name="current_password" class="form-control" id="current_password"
                                    placeholder="Enter current password" autocomplete="current-password" />
                                @error('current_password')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <div class="form-group mb-3 d-flex flex-column">
                                <label for="password" class="form-label">New Password<span class="text-danger fs-5">*</span></label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Enter new password" autocomplete="new-password" />
                                @error('password')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 position-relative">
                            <div class="form-group mb-3 d-flex flex-column">
                                <label for="confirm_password" class="form-label">Confirm New Password<span class="text-danger fs-5">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="confirm_password" placeholder="Confirm new password" autocomplete="new-password" />
                                @error('password_confirmation')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <button type="button" id="updatePasswordBtn" href="javaScript:void(0)"
                                class="btn btn-secondary mt-2">
                                <span id="sendOtpSpinner" class="spinner-border spinner-border-sm d-none"
                                    role="status" aria-hidden="true"></span>
                                Update &
                                Publish</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection


@section('seller-custome-js')

{{-- form submittion --}}
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $('#updatePasswordBtn').on('click', function() {

            const currentPassword = $('#current_password').val();
            const newPassword = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            // Required check
            if (!currentPassword || !newPassword || !confirmPassword) {
                toastr.error('Current password, new password, and confirm password are required');
                return false;
            }

            // Match check
            if (newPassword !== confirmPassword) {
                toastr.error('New Password and Confirm New Password must be the same');
                return false;
            }

            updatePassword();
        });

        function updatePassword() {
            var formData = $('#editsellercompany').serialize();
            $.ajax({
                url: "{{ route('seller.update.password') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message || 'Password updated');
                        setTimeout(function() {
                            window.location.href = response.url || window.location.href;
                        }, 800);
                    } else {
                        toastr.error(response.message || 'Something went wrong');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    const res = xhr.responseJSON;
                    if (res && res.message) {
                        toastr.error(res.message);
                    } else {
                        toastr.error('Failed to submit form');
                    }
                }
            });
        }
    });
</script>
@endsection