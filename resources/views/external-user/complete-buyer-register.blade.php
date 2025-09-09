@extends('external-user.external-frame')
@section('external-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex">
                    <h6 class="fs-5 text-light py-2 pb-3 px-3">Registration Form for Buyer</h6>

                </div>

                <div class="card rounded-0">
                    <form method="post" id="completeBuyer" class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Your First Name:</label>
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="Enter your first name" value="{{ $user->first_name }}" />
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Your Last Name: </label>
                                    <input type="text" name="last_name" value="{{ $user->last_name }}"
                                        class="form-control" placeholder="Enter your last name" />
                                </div>
                            </div>


                            <div class="col-md-6 position-relative">
                                <div class="form-group mb-3 d-flex flex-column">
                                    <label for="" class="form-label">Mobile Number</label>
                                    <input type="tel" name="phone" value="{{ $user->phone }}" id="phone" 
                                        class="form-control" placeholder="Enter your mobile number" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Email Address</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                        placeholder="Enter your email address" />
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
                           



                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Country</label>
                                            <select name="country" id="country" class="form-select">
                                                <option value="">Select Country</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">State</label>
                                            <select name="state" id="state" class="form-select">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">City</label>
                                            <input type="text" name="city" id="city" list="cities"
                                                class="form-control" placeholder="Enter your city"
                                                value="{{ $user->city }}">
                                            <datalist id="cities">

                                            </datalist>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">ZIP Code</label>
                                            <input type="text" name="zip" class="form-control"
                                                placeholder="Enter Your Zip Code" value="{{ $user->zip }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Street</label>
                                            <input type="text" name="street_name" class="form-control"
                                                placeholder="Enter street name" value="{{ $user->street }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">House Number</label>
                                            <input type="number" name="house_no" class="form-control"
                                                placeholder="House Number" value="{{ $user->house_no }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div>
                                <button type="submit" class="btn btn-secondary mt-3">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
   
@endsection

@section('custom-js-external')
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

            // Call the fetchCountries function when the page is loaded
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

            // Call the fetchCountries function when the page is loaded
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

            // Call the fetchCountries function when the page is loaded
            fetchCities();


            // Handle onchange event for the country select
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
            $('#completeBuyer').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = $(this).serialize();

                // Submit form data using AJAX
                $.ajax({
                    url: "{{ route('buyer.complete.profile.save') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response?.message)
                            location.href = response?.url;
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error(xhr.responseText);
                        toastr.error('Failed to submit form');
                    }
                });
            });
        });
    </script>

    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode:true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>
@endsection
