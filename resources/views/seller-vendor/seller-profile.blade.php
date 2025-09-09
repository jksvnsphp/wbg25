@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12  bg-primary py-3 pt-1 pb-5">
                <div class="d-flex">
                    <h6 class="fs-5 text-light my-3 px-3 fw-bold">Edit Seller Profile</h6>

                </div>

                <form method="post" id="editsellercompany" class="card rounded-0">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                           

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <label for="" class="form-label">First Name <span class="text-danger">*</span> </label>
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="Enter your first name" value="{{ $user->first_name }}" />
                                    @error('first_name')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control "
                                        placeholder="Enter your last name" value="{{ $user->last_name }}" />
                                    @error('last_name')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control"
                                        placeholder="Enter your email address" />
                                    @error('email')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <div class="form-group mb-3 d-flex flex-column">
                                    <label for="" class="form-label">Mobile <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control" id="phone"
                                        placeholder="Enter your mobile number" value="{{ $user->phone }}" />
                                    @error('phone')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">Country <span class="text-danger">*</span></label>
                                    <select name="country" id="country" class="form-select">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">State <span class="text-danger">*</span></label>
                                    <select name="state" id="state" class="form-select">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" list="cities" name="city" id="city"
                                        class="form-control" value="{{$user->city}}" placeholder="Enter your city" />
                                    <datalist id="cities">

                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">ZIP Code <span class="text-danger">*</span></label>
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
                                <div class="form-group mb-3">
                                    <label for="" class="form-label">House Number</label>
                                    <input type="number" name="house_no" value="{{ $user->house_no }}"
                                        class="form-control" placeholder="House Number" />
                                    @error('house_no')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                           

                            <div>
                                <button class="btn btn-secondary mt-3" type="submit">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection


@section('seller-custome-js')

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
            
            $('#editsellercompany').submit(function(event) {
                event.preventDefault(); 

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('seller.edit.profile.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // console.log(response);
                        if (response.status) {
                            toastr.success('Successfully Update Your Profile')
                            
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
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>
@endsection
