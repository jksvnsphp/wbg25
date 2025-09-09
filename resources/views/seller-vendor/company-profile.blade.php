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
    </style>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="my-0 pb-4 fs-5 pt-2">My Business Profile</h6>

                <div class="tab-content shadow" id="pills-tabContent">
                    <div class="card rounded-0">
                        <div class="row">
                            <div class="col-xl-9">
                                <h6 class="fs-6 fw-bold mb-0 p-2 pb-0 pt-3">
                                    Company Details
                                </h6>
                                <hr />
                                <div class="table-responsive m-2">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Name Of Company
                                                </td>
                                                <td style="width: 55%">
                                                    {{ isset($seller->company->name) ? $seller->company->name : '' }} </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Company Address
                                                </td>
                                                <td style="width: 55%">
                                                    {{ isset($seller->country->name) ? $seller->country->name : '' }},
                                                    {{ isset($seller->state->name) ? $seller->state->name : '' }},
                                                    {{ isset($seller->city) ? $seller->city : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Email Address
                                                </td>
                                                <td style="width: 55%"> {{ $seller->email }} </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Contact No
                                                </td>
                                                <td style="width: 55%">{{ $seller->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Company Registration Year
                                                </td>
                                                <td style="width: 55%">
                                                    {{ isset($seller->company->company_registeration_year) ? $seller->company->company_registeration_year : '' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Business Type
                                                </td>
                                                <td style="width: 55%">
                                                    {{ isset($seller->company->business_type) ? $seller->company->business_type : '' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Number of employees
                                                </td>
                                                <td style="width: 55%">
                                                    {{ isset($seller->company->key_personnal) ? $seller->company->key_personnal : '' }}
                                                    Employee(s)
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 45%; font-weight: 600">
                                                    Ownership Type
                                                </td>
                                                <td style="width: 55%">
                                                    {{ isset($seller->company->business_type) ? $seller->company->business_type : '' }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-7">
                                        <h6 class="fs-6 fw-bold mb-0 p-2 pb-0 pt-3">
                                            Contact Person
                                        </h6>
                                        <hr />
                                        <div class="card rounded-0 m-2">

                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">Name</td>
                                                            <td style="width: 55%">
                                                                {{ $seller->first_name . ' ' . $seller->last_name }} </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">
                                                                Country
                                                            </td>
                                                            <td style="width: 55%">
                                                                {{ $seller->country->name }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">State</td>
                                                            <td style="width: 55%">{{ $seller->state->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">City</td>
                                                            <td style="width: 55%">{{ $seller->city }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">
                                                                Zip Code
                                                            </td>
                                                            <td style="width: 55%">{{ $seller->zip }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">Street</td>
                                                            <td style="width: 55%">{{ $seller->street }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 45%; font-weight: 600">
                                                                House No
                                                            </td>
                                                            <td style="width: 55%">{{ $seller->house_no }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="m-2 mt-5">
                                            <h6 class="fw-medium">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                {{ $seller->email }}
                                            </h6>
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7005.14247513045!2d77.39483454999998!3d28.6126369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cef9166ea02d7%3A0x9a32f1a301ccc430!2sSector%2069%2C%20Noida%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1708586070667!5m2!1sen!2sin"
                                                style="border: 0; width: 100%; height: 20rem" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                                id="mapFrame"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-2 mt-3">
                                    <h6 class="fs-6">Company Description</h6>
                                    <hr />
                                    <textarea id="company_desc" class="form-control rounded-0" rows="7">{{ isset($seller->company->company_desc) ? $seller->company->company_desc : '' }}</textarea>
                                    <button type="button" id="sendOtpBtn" href="javaScript:void(0)"
                                        class="btn btn-secondary mt-2">
                                        <span id="sendOtpSpinner" class="spinner-border spinner-border-sm d-none"
                                            role="status" aria-hidden="true"></span>
                                        Update &
                                        Publish</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
        
    </section>
    <!-- OTP Modal -->
    <div class="modal fade" id="otpModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="otpModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpModalLabel">Enter OTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="otp-inputs">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp1">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp2">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp3">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp4">
                        <input type="text" class="form-control otp-box " maxlength="1" id="otp5">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="validateOtpBtn" class="btn btn-primary">

                        Validate OTP
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('seller-custome-js')
    <script>
        $(document).ready(function() {
            function sendData(name, value) {

                $.ajax({
                    url: "{{ route('seller.edit.shipping-options') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        value: value
                    },
                    success: function(response) {
                        toastr.success('Data saved successfully');
                    },
                    error: function(xhr) {
                        console.log('Error saving data');
                    }
                });
            }


            $('#company_desc').change(function() {
                sendData('company_desc', $(this).val());
            });
        });
    </script>
    <script>
        var country = "{{ $seller->country->name }}";
        var state = "{{ $seller->state->name }}";
        var city = "{{ $seller->city }}";
        var zipcode = "{{ $seller->zip }}";

        var locationx = `${city}, ${state}, ${country}, ${zipcode}`;
        var source_src =
            `https://www.google.com/maps/embed/v1/place?key=AIzaSyAonK15hotzDslX4ePjIbmizRii-7Ng4QE&q=${encodeURIComponent(locationx)}`;
        // console.log(source_src);
        document.getElementById('mapFrame').src = source_src;
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            // Send OTP
            $('#sendOtpBtn').on('click', function() {
                const button_otp = $(this);
                const spinner_otp = $('#sendOtpSpinner');

                button_otp.prop('disabled', true);
                spinner_otp.removeClass('d-none');
                $.ajax({
                    url: '{{ route('seller.send.otp.business') }}',
                    type: 'POST',
                    success: function(response) {
                        if (response.success) {
                            $('#otpModal').modal('show');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred.');
                    },
                    complete: function() {
                        button_otp.prop('disabled', false);
                        spinner_otp.addClass('d-none');
                    }
                });
            });

            // Validate OTP
            $('#validateOtpBtn').on('click', function() {
                const otp = [
                    $('#otp1').val(),
                    $('#otp2').val(),
                    $('#otp3').val(),
                    $('#otp4').val(),
                    $('#otp5').val()
                ].join('');

                if (otp.length !== 5) {
                    alert('Please enter a valid 5-digit OTP.');
                    return;
                }

                $.ajax({
                    url: '{{ route('seller.validate.otp.business') }}',
                    type: 'POST',
                    data: {
                        otp: otp
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('OTP validated successfully.');
                            $('#otpModal').modal('hide');
                            // Redirect to the next step
                            window.location.href = response.url;
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('An error occurred.');
                    }
                });
            });
        });
    </script>
@endsection
