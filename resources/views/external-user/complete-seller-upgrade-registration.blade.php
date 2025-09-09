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
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12  bg-primary py-3 pt-1 pb-5">
                <div class="d-flex">
                    <h6 class="fs-5 text-light my-3 px-3 fw-bold">Registration form for buyer (Upgrade to seller)</h6>
                </div>

                <form method="post" id="completeSeller" class="card rounded-0">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Company Name <span
                                            class="text-danger fs-5">*</span></label>
                                    <input type="text" class="form-control" name="company_name"
                                        value="{{ isset($user->company->name) ? $user->company->name : '' }}"
                                        placeholder="Enter your company name" />
                                    @error('company_name')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Contact person <span
                                                    class="text-danger fs-5">*</span></label>
                                            <input type="text" id="first_name" name="first_name" class="form-control"
                                                placeholder="Enter your first name" value="{{ $user->first_name }}" />
                                            @error('first_name')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label"> </label>
                                            <input type="text" name="last_name" class="form-control mt-2"
                                                placeholder="Enter your last name" value="{{ $user->last_name }}" />
                                            @error('last_name')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Email Address <span
                                            class="text-danger fs-5">*</span></label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                        placeholder="Enter your email address" />
                                    @error('email')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <div class="form-group mb-3 d-flex flex-column">
                                    <label for="" class="form-label">Mobile <span
                                            class="text-danger fs-5">*</span></label>
                                    <input type="tel" name="phonenm" class="form-control" id="phonenm"
                                        placeholder="Enter your mobile number" value="{{ $user->phone }}" />
                                    @error('phone')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                    <input type="hidden" name="phone" id="phone" value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <div class="form-group mb-3 d-flex flex-column">
                                    <label for="" class="form-label">Password<span
                                            class="text-danger fs-5">*</span></label>
                                    <input type="text" name="password" class="form-control" id="password"
                                        placeholder="Enter your password" />
                                    @error('password')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <div class="form-group mb-3 d-flex flex-column">
                                    <label for="" class="form-label">Confirm Password<span
                                            class="text-danger fs-5">*</span></label>
                                    <input type="text" name="password_confirmation" class="form-control"
                                        id="confirm_password" placeholder="Enter your confirm password" />
                                    @error('password_confirmation')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="registration_year" class="form-label">Company Registration Year <span
                                            class="text-danger fs-5">*</span></label>
                                    <select class="form-select" name="registration_year" id="registration_year">
                                        {{-- please loop start from the current year to 1990  --}}
                                        @php
                                            $currentYear = date('Y');
                                        @endphp

                                        @for ($year = $currentYear; $year >= 1850; $year--)
                                            @php
                                                $rg_year = isset($user->company->company_registeration_year)
                                                    ? $user->company->company_registeration_year
                                                    : '';
                                            @endphp
                                            <option @selected($year == $rg_year) value="{{ $year }}">
                                                {{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Number of Employees <span
                                            class="text-danger fs-5">*</span></label>
                                    <select class="form-select" name="number_of_employees" id="number_of_employees">
                                        @php
                                            $keyPersonnelRoles = [
                                                '1-5',
                                                '5-10',
                                                '10-20',
                                                '20-50',
                                                '50-100',
                                                '100-500',
                                                '500-1000',
                                                'More then 1000',
                                            ];
                                        @endphp
                                        <option value="">Select number of employees</option>
                                        @foreach ($keyPersonnelRoles as $role)
                                            @php
                                                $role_type = isset($user->company->key_personnal)
                                                    ? $user->company->key_personnal
                                                    : '';
                                            @endphp
                                            <option @selected($role == $role_type) value="{{ $role }}">
                                                {{ $role }}</option>
                                        @endforeach
                                    </select>
                                    @error('number_of_employees')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Business Type <span
                                            class="text-danger fs-5">*</span></label>
                                    <select class="form-select" name="business_type" id="business_type">
                                        @php
                                            $businessTypes = [
                                                'Manufacturer',
                                                'Wholesaler',
                                                'Retailer',
                                                'Service Provider',
                                            ];
                                        @endphp
                                        <option value="">Business Type</option>
                                        @foreach ($businessTypes as $type)
                                            @php
                                                $business_type = isset($user->company->business_type)
                                                    ? $user->company->business_type
                                                    : '';
                                            @endphp
                                            <option @selected($type == $business_type) value="{{ $type }}">
                                                {{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('business_type')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <h6 class="mt-3 fw-bold">Certification</h6>
                            <div class="col-md-12 my-4">
                                <div class="row">
                                    @php
                                        $certifications = [
                                            'HACCP',
                                            'ISO 9001:2000',
                                            'ISO 9001:2008',
                                            'QS-9000',
                                            'ISO 14001:2004',
                                            'ISO/TS 16949',
                                            'SA8000',
                                            'ISO 17799',
                                            'OHSAS 18001',
                                            'TL 9000',
                                            'Other',
                                        ];
                                        $selectedCertifications = [];
                                        if (isset($user->company->certifications)) {
                                            $selectedCertifications = json_decode(
                                                isset($user->company->certifications)
                                                    ? $user->company->certifications
                                                    : [],
                                            );
                                        }
                                    @endphp
                                    @foreach (array_chunk($certifications, 2) as $chunk)
                                        <div class="col-md-2">
                                            <ul class="mx-0 px-0 list-unstyled">
                                                @foreach ($chunk as $certification)
                                                    <li class="d-flex mt-2">
                                                        <input class="me-3"
                                                            @if ($certification == 'Other') onchange="other_certificate_select(event)" @endif
                                                            type="checkbox"
                                                            @if (in_array($certification, $selectedCertifications)) checked @endif
                                                            name="certifications[]" value="{{ $certification }}"
                                                            id="{{ $certification }}" />
                                                        <label for="{{ $certification }}">{{ $certification }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group" id="other_certificate_gp"
                                            @if ($certification == 'Other' && in_array('Other', $selectedCertifications)) style="display: block;" @else style="display: none;" @endif>
                                            <label for="other_certificate" class="form-label mb-4">Other (please
                                                specify)</label>
                                            @if ($certification == 'Other' && in_array('Other', $selectedCertifications))
                                                @if (isset($user->company->other_certificate) && json_decode($user->company->other_certificate) != null)
                                                    @php
                                                        $others = json_decode($user->company->other_certificate);
                                                    @endphp
                                                @endif
                                            @endif
                                            <div class="row">
                                                <div class="mb-3 col-md-3">
                                                    <label for="other_certificate1" class="form-label">Certificate
                                                        1</label>
                                                    <input type="text" name="other_certificate[]"
                                                        value="{{ isset($others[0]) ? $others[0] : '' }}"
                                                        id="other_certificate1" class="form-control">
                                                </div>
                                                <div class="mb-3  col-md-3">
                                                    <label for="other_certificate2" class="form-label">Certificate
                                                        2</label>
                                                    <input type="text" name="other_certificate[]"
                                                        value="{{ isset($others[1]) ? $others[1] : '' }}"
                                                        id="other_certificate2" class="form-control">
                                                </div>
                                                <div class="mb-3  col-md-3">
                                                    <label for="other_certificate3" class="form-label">Certificate
                                                        3</label>
                                                    <input type="text" name="other_certificate[]"
                                                        value="{{ isset($others[2]) ? $others[2] : '' }}"
                                                        id="other_certificate3" class="form-control">
                                                </div>
                                                <div class="mb-3  col-md-3">
                                                    <label for="other_certificate4" class="form-label">Certificate
                                                        4</label>
                                                    <input type="text" name="other_certificate[]"
                                                        value="{{ isset($others[3]) ? $others[3] : '' }}"
                                                        id="other_certificate4" class="form-control">
                                                </div>
                                                <div class="mb-3  col-md-3">
                                                    <label for="other_certificate5" class="form-label">Certificate
                                                        5</label>
                                                    <input type="text" name="other_certificate[]"
                                                        value="{{ isset($others[4]) ? $others[4] : '' }}"
                                                        id="other_certificate5" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function other_certificate_select(e) {
                                               
                                                if (e.target.checked) {
                                                    document.getElementById('other_certificate_gp').style.display = 'block';
                                                } else {
                                                    document.querySelector('#other_certificate_gp').style.display = 'none';
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Country <span
                                                    class="text-danger fs-5">*</span></label>
                                            <select name="country" id="country" class="form-select">
                                                <option value="">Select Country</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">State <span
                                                    class="text-danger fs-5">*</span></label>
                                            <select name="state" id="state" class="form-select">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">City <span
                                                    class="text-danger fs-5">*</span></label>
                                            <input type="text" list="cities" name="city" id="city"
                                                class="form-control" value="{{ $user->city }}"
                                                placeholder="Enter your city" />
                                            <datalist id="cities">

                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">ZIP Code <span
                                                    class="text-danger fs-5">*</span></label>
                                            <input type="text" class="form-control" name="zip"
                                                value="{{ $user->zip }}" placeholder="Enter Zip Code" />
                                            @error('zip')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Street</label>
                                            <input type="text" class="form-control" name="street"
                                                value="{{ $user->street }}" placeholder="Enter street name" />
                                            @error('street')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        {{-- @php
                                            dd($user);
                                        @endphp --}}
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">House Number</label>
                                            <input type="number" name="house_no" value="{{ $user->house_no }}"
                                                class="form-control" placeholder="House Number" />
                                            @error('house_no')
                                                <span class="text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label for="categorySelect" class="form-label">Company Category
                                                    </label>
                                                    <select name="company_category" id="categorySelect"
                                                        class="form-select">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $category)
                                                            <option @selected($category->id == (isset($user->company->category_1) ? $user->company->category_1 : ''))
                                                                value="{{ $category->id }}">
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" name="package_code" value="{{ $package->code ?? '' }}">
                                                <div class="form-group mb-2">
                                                    <label for="subCategorySelect" class="form-label">Sub Category
                                                    </label>
                                                    <select
                                                        value="{{ isset($user->company->category_2) ? $user->company->category_2 : '' }}"
                                                        name="company_sub_category" id="subCategorySelect"
                                                        class="form-select">
                                                        <option value="">Select Subcategory</option>

                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <button id="sendotpbtn" class="btn btn-secondary mt-3" type="submit">
                                        Save
                                        <span id="spinner" class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true" style="display:none;"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                </form>
                <span data-bs-toggle="modal" data-bs-target="#registerotp" class="d-none" id="openOtppopup"></span>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal  fade " id="registerotp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="registerotpLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-6" id="registerotpLabel">
                        Verify phone number
                    </h1>
                    <i class="fa-solid fa-xmark text-secondary pointer-event" id="deleteModal" data-bs-dismiss="modal"
                        aria-label="Close" style="cursor: pointer !important;"></i>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="phone" class="form-label fw-bolder">Phone Number<span></span></label>
                            <div class="input-group w-100 mb-3">
                                <input type="text" class="form-control" placeholder="Enter your phone number.."
                                    name="phone" id="phone2" />
                                <button class="input-group-btn btn btn-primary" id="verifybtn">Verify</button>
                            </div>
                        </div>
                    </div>
                    <form id="otpForm" class="d-none mt-3">

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
                            <small class="text-success text-center py-2">Testing Code 12345</small>
                            <button type="button" class="btn btn-primary my-4" onclick="validateOTP()">
                                Validate Code
                            </button>
                            <div id="resendOtpContainer" class="d-none">
                                <small class="text-danger">Didn't receive Code? <button class="btn btn-link p-0"
                                        id="resendOtpBtn">Resend Code</button></small>
                            </div>
                            <small id="timerText" class="text-muted">You can resend code in <span id="timer">30</span>
                                seconds.</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js-external')
    <script>
        var isValidate = false;
        var oldPhone = 0;
        var countdownTimer;
        var timerValue = 30;

        function moveToNext(currentInput, nextInputId) {
            var maxLength = parseInt(currentInput.getAttribute("maxlength"));
            var currentLength = currentInput.value.length;
            if (currentLength >= maxLength && nextInputId) {
                document.getElementById(nextInputId).focus();
            }
        }

        function startTimer() {
            $('#resendOtpContainer').addClass('d-none');
            $('#timerText').removeClass('d-none');
            $('#verifybtn').attr('disabled', true); 
            timerValue = 30;
            $('#timer').text(timerValue);

            countdownTimer = setInterval(function() {
                timerValue--;
                $('#timer').text(timerValue);
                if (timerValue <= 0) {
                    clearInterval(countdownTimer);
                    $('#resendOtpContainer').removeClass('d-none');
                    $('#timerText').addClass('d-none');
                }
            }, 1000);
        }

        function validateOTP() {
            var otp1 = document.getElementById("otp1").value;
            var otp2 = document.getElementById("otp2").value;
            var otp3 = document.getElementById("otp3").value;
            var otp4 = document.getElementById("otp4").value;
            var otp5 = document.getElementById("otp5").value;

            var otp = otp1 + otp2 + otp3 + otp4 + otp5;

            if (otp === "12345") {
                oldPhone = $('#phone').val();
                isValidate = true;
                toastr.success('Code Verified Successfully');
                $('#deleteModal').click();
                submitForm(); 
            } else {
                toastr.error("Invalid Code. Please try again.");
            }
        }

        function submitForm() {
            var formData = $('#completeSeller').serialize();
            $('#sendotpbtn').attr('disabled', true); 
            $('#spinner').show();
            $.ajax({
                url: "{{ route('buyer-upgrade.complete.profile.save') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        
                        $('#sendotpbtn').attr('disabled', false);
                        $('#spinner').hide();
                        console.log(response);
                        location.href=response?.url;
                    } else {
                        let errors = response.error;
                        for (let field in errors) {
                            toastr.error(errors[field][0]);
                        }
                        $('#sendotpbtn').attr('disabled', false);
                        $('#spinner').hide();
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toastr.error('Failed to submit form');
                    $('#sendotpbtn').attr('disabled', false);
                    $('#spinner').hide();
                }
            });
        }

        $(document).ready(function() {
            // When 'Send OTP' is clicked
            $('#sendotpbtn').on('click', function(e) {
                e.preventDefault();
                $('#otp1').val(''); // Clear OTP input fields
                $('#otp2').val('');
                $('#otp3').val('');
                $('#otp4').val('');
                $('#otp5').val('');
                var mobile = $('#phone').val();
                var name = $('#first_name').val();
                if (mobile === '') {
                    toastr.error('Please enter your mobile number');
                    return;
                }
                if (name === '') {
                    toastr.error('Please enter your name');
                    return;
                }
                if (!isValidate || (oldPhone !== mobile)) {
                    var registerotp = new bootstrap.Modal($('#registerotp'), {
                        keyboard: false
                    });
                    registerotp.show();
                    $('#phone2').val(mobile); // Show the mobile number in the modal
                    $('#otpForm').addClass('d-none');
                   
                    // When 'Verify' button is clicked
                    $('#verifybtn').on('click', function() {
                        $(this).attr('disabled', true); 
                        $('#otpForm').removeClass('d-none');
                        startTimer();
                        // validateOTP(); 
                    });
                } else {
                    submitForm();
                }
            });

            // When 'Resend OTP' is clicked
            $('#resendOtpBtn').on('click', function() {
                clearInterval(countdownTimer); // Clear previous timer
                $('#verifybtn').attr('disabled', false); // Enable Verify button for Resend OTP
                $('#otp1').val(''); // Clear OTP fields
                $('#otp2').val('');
                $('#otp3').val('');
                $('#otp4').val('');
                $('#otp5').val('');
                startTimer(); // Restart the timer for Resend OTP
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to fetch countries and populate the select element
            function fetchCountries() {
                $.ajax({
                    url: "{{ route('all.countries') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Clear previous options
                        $('#country').empty();
                        // Add each country as an option
                        $('#country').append('<option value="">Select Country</option>');
                        $.each(response, function(index, country) {
                            var oldCountry = "{{ $user->country }}";
                            if (oldCountry == country.id) {
                                $('#country').append('<option value="' + country.id +
                                    '" selected>' + country.name +
                                    '</option>');
                                fetchStates(country.id)
                            } else {

                                $('#country').append('<option  value="' + country.id + '">' +
                                    country
                                    .name + '</option>');
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Failed to fetch countries.');
                    }
                });
            }
            fetchCountries();
            function fetchStates(countryId) {
                $.ajax({
                    url: "{{ route('all.states') }}",
                    type: 'GET',
                    data: {
                        country_id: countryId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#state').empty();
                        $('#state').append('<option value="">Select State</option>');
                        $.each(response, function(index, state) {
                            var oldState = "{{ $user->state }}";
                            if (oldState == state.id) {
                                $('#state').append('<option value="' + state.id +
                                    '" selected>' + state.name +
                                    '</option>');
                                fetchCities(state.id)
                            } else {

                                $('#state').append('<option  value="' + state.id + '">' +
                                    state
                                    .name + '</option>');
                            }

                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Failed to fetch states.');
                    }
                });
            }
            fetchStates();
            function fetchCities(stateId) {
                $.ajax({
                    url: "{{ route('all.cities') }}",
                    type: 'GET',
                    data: {
                        state_id: stateId
                    }, 
                    dataType: 'json',
                    success: function(response) {
                        
                        $('#cities').empty();

                        $.each(response, function(index, city) {
                            $('#cities').append('<option value="' + city.name + '">');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Failed to fetch cities.');
                    }
                });
            }
            fetchCities();
            $('#country').change(function() {
                var countryId = $(this).val();
                if (countryId) {
                    fetchStates(countryId);
                } else {
                    $('#state').empty(); 
                }
            });
            $('#state').change(function() {
                var stateId = $(this).val();
                if (stateId) {
                    fetchCities(stateId);
                } else {
                    $('#cities').empty();
                }
            });
        });
    </script>



    <script>
        const codeinput = document.querySelector("#phonenm");
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
        function fetchSubCategory() {
            let categoryId = $('#categorySelect').val();
            if (categoryId) {
                $.ajax({
                    url: '{{ route('all.supplier-subcategory') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: categoryId
                    },
                    success: function(response) {
                        let subCategorySelect = $('#subCategorySelect');
                        subCategorySelect.empty(); 
                        subCategorySelect.append('<option value="">Select Subcategory</option>');
                        if (response.status) {
                            var data = response.categories;
                            var oldSubCategory =
                                "{{ isset($user->company->category_2) ? $user->company->category_2 : '' }}";
                            $.each(data, function(key, subcategory) {
                                var selected = (oldSubCategory == subcategory.id) ? "selected" : "";
                                subCategorySelect.append('<option ' + selected + ' value="' +
                                    subcategory.id +
                                    '">' +
                                    subcategory.category_name + '</option>');
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subCategorySelect').empty().append('<option value="">Select Subcategory</option>');
            }
        }
        fetchSubCategory();
        $('#categorySelect').on('change', function() {
            let categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: '{{ route('all.supplier-subcategory') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: categoryId
                    },
                    success: function(response) {
                        let subCategorySelect = $('#subCategorySelect');
                        subCategorySelect.empty(); // Clear existing options
                        subCategorySelect.append('<option value="">Select Subcategory</option>');
                        if (response.status) {
                            var data = response.categories;
                            $.each(data, function(key, subcategory) {
                                subCategorySelect.append('<option value="' + subcategory.id +
                                    '">' +
                                    subcategory.category_name + '</option>');
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching subcategories.');
                    }
                });
            } else {
                $('#subCategorySelect').empty().append('<option value="">Select Subcategory</option>');
            }
        });
    </script>
@endsection
