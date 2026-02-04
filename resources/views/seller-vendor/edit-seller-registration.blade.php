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
        <div class="col-md-12  bg-primary py-3 pt-1 pb-5">
            <div class="d-flex">
                <h6 class="fs-5 text-light my-3 px-3 fw-bold">Update Profile</h6>

            </div>

            <form method="post" id="editsellercompany" class="card rounded-0">
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
                                        <input type="text" name="first_name" class="form-control"
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
                                <input type="email" name="email" id="changeEmail" value="{{ $user->email }}" class="form-control"
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
                        <!--<div class="col-md-6 position-relative">
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
                            </div>--->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="registration_year" class="form-label">Company Registration Year <span
                                        class="text-danger fs-5">*</span></label>
                                <select class="form-select" name="registration_year" id="registration_year">
                                    {{-- please loop start from the current year to 1850  --}}
                                    @php
                                    $currentYear = date('Y');
                                    @endphp

                                    @for ($year = $currentYear; $year >= 1850; $year--)
                                    @php
                                    $rg_year = isset($user->company->company_registeration_year)
                                    ? $user->company->company_registeration_year
                                    : '';
                                    @endphp
                                    <option @selected($year==$rg_year) value="{{ $year }}">
                                        {{ $year }}
                                    </option>
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
                                    <option @selected($role==$role_type) value="{{ $role }}">
                                        {{ $role }} Employee(s)
                                    </option>
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
                                    <option value="">Select Business Type</option>
                                    @foreach ($businessTypes as $type)
                                    @php
                                    $business_type = isset($user->company->business_type)
                                    ? $user->company->business_type
                                    : '';
                                    @endphp
                                    <option @selected($type==$business_type) value="{{ $type }}">
                                        {{ $type }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('business_type')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <h6 class="mt-3 d-none fw-bold">Certification</h6>
                        <div class="col-md-12 d-none my-4">
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
                                                @if ($certification=='Other' ) onchange="other_certificate_select(event)" @endif
                                                type="checkbox"
                                                @if (is_array($selectedCertifications) && in_array($certification, $selectedCertifications)) checked @endif
                                                name="certifications[]" value="{{ $certification }}"
                                                id="{{ $certification }}" />
                                            <label for="{{ $certification }}">{{ $certification }}</label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endforeach
                                <div class="col-md-4 mt-3">
                                    <div class="form-group" id="other_certificate_gp"
                                        @if ($certification=='Other' && is_array($selectedCertifications) && in_array('Other', $selectedCertifications)) style="display: block;" @else style="display: none;" @endif>
                                        <label for="other_certificate" class="form-label mb-4">Other (please
                                            specify)</label>
                                        @if ($certification == 'Other' && is_array($selectedCertifications) && in_array('Other', $selectedCertifications))
                                        @if (isset($user->company->other_certificate) && json_decode($user->company->other_certificate) != null)
                                        @php
                                        $others = json_decode($user->company->other_certificate);
                                        @endphp
                                        @endif
                                        @endif
                                        <div class="mb-3">
                                            <label for="other_certificate1" class="form-label">Certificate 1</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[0]) ? $others[0] : '' }}"
                                                id="other_certificate1" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate2" class="form-label">Certificate 2</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[1]) ? $others[1] : '' }}"
                                                id="other_certificate2" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate3" class="form-label">Certificate 3</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[2]) ? $others[2] : '' }}"
                                                id="other_certificate3" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate4" class="form-label">Certificate 4</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[3]) ? $others[3] : '' }}"
                                                id="other_certificate4" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="other_certificate5" class="form-label">Certificate 5</label>
                                            <input type="text" name="other_certificate[]"
                                                value="{{ isset($others[4]) ? $others[4] : '' }}"
                                                id="other_certificate5" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <script>
                                    function other_certificate_select(e) {
                                        // alert(e.target.value)
                                        if (e.target.value == "Other") {
                                            document.getElementById('other_certificate_gp').style.display = 'block';
                                        } else {
                                            document.getElementById('other_certificate_gp').style.display = 'none';
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <h6 class="mt-3  fw-bold">Company Description</h6>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <textarea name="description" class="form-control" id="description" rows="7">{{ $user->company->company_desc ?? '' }}</textarea>
                            </div>
                        </div>
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
                                    placeholder="Enter your city" required />
                                <datalist id="cities">

                                </datalist>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">ZIP Code <span
                                        class="text-danger fs-5">*</span></label>
                                <input type="text" class="form-control" name="zip"
                                    value="{{ $user->zip }}" placeholder="Enter Zip Code" required />
                                @error('zip')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">Street <span
                                        class="text-danger fs-5">*</span></label>
                                <input type="text" class="form-control" name="street"
                                    value="{{ $user->street }}" placeholder="Enter street name" required />
                                @error('street')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">House Number <span
                                        class="text-danger fs-5">*</span></label>
                                <input type="text" name="house_no" value="{{ $user->house_no }}"
                                    class="form-control" placeholder="House Number" required />
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
                                        <select name="company_category" id="categorySelect" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                            <option @selected($category->id == (isset($user->company->category_1) ? $user->company->category_1 : '')) value="{{ $category->id }}">
                                                {{ $category->category_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label for="subCategorySelect" class="form-label">Sub Category
                                        </label>
                                        <select
                                            value="{{ isset($user->company->category_2) ? $user->company->category_2 : '' }}"
                                            name="company_sub_category" id="subCategorySelect" class="form-select">
                                            <option value="">Select Subcategory</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="button" id="sendOtpBtn" href="javaScript:void(0)"
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

<!-- OTP Modal -->
<div class="modal fade" id="otpModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="otpModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpModalLabel">Verify Your Identity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="otpOptions">
                    <p>Please select how you want to receive your verification code:</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="otpMethod" id="emailOtpOption"
                            value="email" checked>
                        <label class="form-check-label" for="emailOtpOption">
                            Send code to email address
                        </label>
                        <div class="text-muted small" id="showEmail">{{ $user->email }}</div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="otpMethod" id="mobileOtpOption"
                            value="mobile">
                        <label class="form-check-label" for="mobileOtpOption">
                            Send code to mobile number
                        </label>
                        <div class="text-muted small" id="showphone">{{ $user->phone }}</div>
                    </div>
                </div>

                <div id="otpInputSection" style="display: none;">
                    <p class="mb-3">Enter the 5-digit code sent to <span id="codeSentTo"></span></p>
                    <div class="otp-inputs">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp1"
                            autocomplete="off">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp2"
                            autocomplete="off">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp3"
                            autocomplete="off">
                        <input type="text" class="form-control otp-box me-2" maxlength="1" id="otp4"
                            autocomplete="off">
                        <input type="text" class="form-control otp-box" maxlength="1" id="otp5"
                            autocomplete="off">
                    </div>
                    <div class="mt-2">
                        <a href="javascript:void(0)" id="resendOtpLink" class="small">Resend code</a>
                        <span id="resendTimer" class="small text-muted ms-2" style="display: none;"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="sendOtpMethodBtn" class="btn btn-primary">Send Code</button>
                <button id="validateOtpBtn" class="btn btn-primary" style="display: none;">Verify Code</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('seller-custome-js')
<script>
    $(document).ready(function() {

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
                }, // Pass country ID as parameter
                dataType: 'json',
                success: function(response) {
                    // Clear previous options
                    $('#state').empty();
                    // Add each state as an option
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
                }, // Pass country ID as parameter
                dataType: 'json',
                success: function(response) {
                    // Clear previous options
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
                $('#state').empty(); // Clear state options if no country selected
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


{{-- form submittion --}}
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        function getFieldLabel($field) {
            const id = $field.attr('id');
            let labelText = '';

            const $groupLabel = $field.closest('.form-group').find('label').first();
            if ($groupLabel.length) {
                labelText = $groupLabel.text();
            } else if (id) {
                const $forLabel = $('label[for="' + id + '"]').first();
                if ($forLabel.length) {
                    labelText = $forLabel.text();
                }
            }

            labelText = (labelText || '').replace(/\*/g, '').trim();
            if (labelText) return labelText;

            const placeholder = ($field.attr('placeholder') || '').trim();
            if (placeholder) return placeholder;

            return ($field.attr('name') || 'This field');
        }

        function validateProfileFormBeforeOtp() {
            const $form = $('#editsellercompany');
            $form.find('.is-invalid').removeClass('is-invalid');

            const optionalNames = new Set(['description']);

            const $fields = $form
                .find('input, select, textarea')
                .filter(':visible')
                .filter(function() {
                    const $el = $(this);
                    const name = $el.attr('name');
                    const type = ($el.attr('type') || '').toLowerCase();

                    if (!name) return false;
                    if (optionalNames.has(name)) return false;
                    if (name === '_token' || name === 'user_id') return false;
                    if (type === 'hidden' || type === 'button' || type === 'submit') return false;
                    if ($el.is(':disabled')) return false;
                    return true;
                });

            for (let i = 0; i < $fields.length; i++) {
                const $field = $($fields[i]);
                const tag = ($field.prop('tagName') || '').toLowerCase();
                const type = ($field.attr('type') || '').toLowerCase();

                let value = '';
                if (tag === 'select') {
                    value = ($field.val() || '').toString().trim();
                } else if (type === 'checkbox' || type === 'radio') {
                    // If you later add required checkboxes/radios, handle here
                    continue;
                } else {
                    value = ($field.val() || '').toString().trim();
                }

                if (!value) {
                    const label = getFieldLabel($field);
                    $field.addClass('is-invalid').focus();
                    toastr.error(label + ' is required.');
                    return false;
                }
            }

            return true;
        }

        // OTP Handling
        let otpMethod = 'email';
        let resendTimeout = null;

        // Auto-tab between OTP inputs  
        $('.otp-box').keyup(function() {
            if (this.value.length === this.maxLength) {
                $(this).next('.otp-box').focus();
            }
        });

        // Send OTP Method
        $('#sendOtpBtn').on('click', function() {
            if (!validateProfileFormBeforeOtp()) {
                return;
            }
            $('#otpModal').modal('show');
            $('#showEmail').text($('#changeEmail').val());
            $('#showphone').text($('#phonenm').val());

        });

        // Handle OTP method selection
        $('#sendOtpMethodBtn').on('click', function() {
            if (!validateProfileFormBeforeOtp()) {
                return;
            }
            otpMethod = $('input[name="otpMethod"]:checked').val();
            const phone = $('#phonenm').val();
            const email = $('#changeEmail').val();
            const button = $(this);
            const spinner = $('<span>', {
                class: 'spinner-border spinner-border-sm',
                role: 'status',
                'aria-hidden': 'true'
            });

            const countryData = iti.getSelectedCountryData();
            // const countryCode = calCodeountryData.iso2; // This will give you the ISO 2-letter country code (e.g., "us", "gb")
            const dialCode = '+91'; // countryData.di; // This will give you the country dial code (e.g., "1", "44")alCode; // This will give you the country dial code (e.g., "1", "44")  
            // console.log('Selected country code:', countryCode);
            console.log('Dial code:', dialCode);
            button.prop('disabled', true).prepend(spinner);

            $.ajax({
                url: '{{ route("seller.send.otp.business") }}',
                type: 'POST',
                data: {
                    otp_method: otpMethod,
                    phone: dialCode + phone,
                    email: email
                },
                success: function(response) {
                    if (response.success) {
                        // Show OTP input section
                        $('#otpOptions').hide();
                        $('#otpInputSection').show();
                        $('#sendOtpMethodBtn').hide();
                        $('#validateOtpBtn').show();

                        // Update where code was sent
                        const sentTo = otpMethod === 'email' ?
                            '{{ $user->email }}' :
                            '{{ $user->phone }}';
                        $('#codeSentTo').text(sentTo);

                        // Start resend timer (60 seconds)
                        startResendTimer();

                        // Focus first OTP input
                        $('#otp1').focus();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while sending the code.');
                },
                complete: function() {
                    button.prop('disabled', false).find('.spinner-border').remove();
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
                url: '{{ route("seller.validate.otp.business") }}',
                type: 'POST',
                data: {
                    otp: otp
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('OTP validated successfully.');
                        $('#otpModal').modal('hide');
                        updateBusinessProfile();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred.');
                }
            });
        });
        // Resend OTP
        $('#resendOtpLink').on('click', function() {
            if ($(this).hasClass('disabled')) return;

            const link = $(this);
            link.addClass('disabled');

            $.ajax({
                url: '{{ route("seller.send.otp.business") }}',
                type: 'POST',
                data: {
                    otp_method: otpMethod
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('New code sent successfully!');
                        startResendTimer();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while resending the code.');
                },
                complete: function() {
                    setTimeout(() => link.removeClass('disabled'), 1000);
                }
            });
        });

        // Start resend timer
        function startResendTimer() {
            let seconds = 60;
            $('#resendOtpLink').hide();
            $('#resendTimer').text(`Resend code in ${seconds} seconds`).show();

            resendTimeout = setInterval(function() {
                seconds--;
                $('#resendTimer').text(`Resend code in ${seconds} seconds`);

                if (seconds <= 0) {
                    clearInterval(resendTimeout);
                    $('#resendTimer').hide();
                    $('#resendOtpLink').show();
                }
            }, 1000);
        }

        // Clear timer when modal closes
        $('#otpModal').on('hidden.bs.modal', function() {
            if (resendTimeout) {
                clearInterval(resendTimeout);
            }
            // Reset modal state
            $('#otpOptions').show();
            $('#otpInputSection').hide();
            $('#sendOtpMethodBtn').show();
            $('#validateOtpBtn').hide();
            $('.otp-box').val('');
        });

        function updateBusinessProfile() {
            var formData = $('#editsellercompany').serialize();
            $.ajax({
                url: "{{ route('seller.edit.profile.save') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status) {
                        location.href = response.url;
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error('Failed to submit form');
                }
            });
        }
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
                url: '{{ route("all.supplier-subcategory") }}',
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
                url: '{{ route("all.supplier-subcategory") }}',
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