@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <style>
        #imagePreview .preview-img {
            position: relative;
            width: 70px;
            height: 70px;
            margin: 5px;
            cursor: pointer;
        }

        .preview-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
        }

        .preview-img .delete-icon {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff0000;
            color: white;
            border-radius: 50%;
            font-size: 1rem;
            height: 2rem;
            width: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        #categoryModal {
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        /* WebKit browsers (Chrome, Safari, Edge) */
        #categoryModal::-webkit-scrollbar {
            width: 10px;
        }

        #categoryModal::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #categoryModal::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
            border: 2px solid #f1f1f1;
        }

        #categoryModal::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        /* For Firefox */
        #categoryModal {
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        #categoryModal .list-group-item {
            cursor: pointer;
        }

        #categoryModal .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .form-check-input:focus {
            box-shadow: none;
        }

        .form-check-input:checked {
            background-color: #f85f06;
            border-color: #f85f06;
        }

        .select2-container .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }

        #loadingOverlay .spinner-border {
            width: 50px;
            height: 50px;
        }



        .list-group::-webkit-scrollbar {
            display: none;
        }

        .list-group {
            scrollbar-width: none;
        }

        .list-group {
            overflow-y: auto;
        }
    </style>
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
            <img src="{{ asset('uploads/loading-gif.gif') }}" class="h-100 w-100" alt="">
        </div>
    </div>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">Add Product</h6>

                <div class="card shadow rounded-0">


                    <form class="card-body" id="add_product_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <h6 class="fw-bold text-primary fs-5">
                                    Start your listing and make Money selling on World Business
                                    Guide - www.wbg24.com
                                </h6>

                            </div>
                            @livewire('category-suggestion')
                            <div class="col-md-9 mt-4">
                                <h6 class="text-uppercase fw-bold fs-6">
                                    Enter Color, Size and No. of pieces
                                </h6>
                                <div id="itemRows">
                                    <div class="row align-items-center justify-content-start mb-3">
                                        <div class="col-auto">
                                            <input type="checkbox" class="form-check-input" name="data_atr[0]" />
                                        </div>

                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Color"
                                                name="color_atr[0]">
                                        </div>
                                        -
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Size"
                                                name="size_atr[0]">
                                        </div>
                                        -
                                        <div class="col">
                                            <input type="number" class="form-control" placeholder="Quantity"
                                                name="quantity_atr[0]">
                                        </div>
                                        <div class="col-auto">
                                            <a href="javaScript:void(0)" class="text-primary add-row">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">

                                <div class="row justify-content-between">

                                    <div class="col-12">


                                        {{-- photos --}}
                                        <div class="row mt-4">
                                            <h6 class="text-uppercase fw-bold fs-6">
                                                Uploads Product Pictures and Product Video
                                            </h6>
                                            <small id="imageCount">0 of 4 Photos</small>
                                            <div id="imageDropArea" class="col-md-8 mb-3">
                                                <label for="images" class="card"
                                                    style="height: 12rem; border: 1px dotted #818181; cursor: pointer;">
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-items-center h-100">
                                                        <i
                                                            class="fa-solid rounded-circle bg-body-secondary p-2 fa-cloud-arrow-up fs-4"></i>
                                                        <h6 class="fw-bold mt-3">Upload Photos</h6>
                                                        <small>or drag and drop</small>
                                                    </div>
                                                </label>
                                                <input type="file" name="images[]" id="images" accept="image/*"
                                                    class="d-none" multiple />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="video" class="card"
                                                    style="height: 12rem; border: 1px dotted #818181; cursor: pointer;">
                                                    <div
                                                        class="d-flex flex-column justify-content-center align-items-center h-100">
                                                        <i
                                                            class="fa-solid rounded-circle bg-body-secondary p-2 fa-photo-film fs-4"></i>
                                                        <h6 class="fw-bold mt-3">Upload Video</h6>
                                                        <small>or drag and drop</small>
                                                    </div>
                                                </label>
                                                <input type="file" name="video" id="video" accept="video/*"
                                                    class="d-none" />
                                                <div id="videoPreview" class="mt-2"></div>
                                                <!-- Video preview will go here -->
                                            </div>
                                            <div id="imagePreview" class="d-flex flex-wrap mt-2"></div>

                                        </div>
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <div
                                                    class="form-group mt-2 d-flex align-items-center flex-sm-nowrap flex-wrap">
                                                    <label for="item_title" class="form-label fw-bold mb-sm-0 md-2 me-2"
                                                        style="white-space: nowrap;">Item Title:</label>
                                                    <input type="text" name="item_title" id="item_title"
                                                        class="form-control" placeholder="Enter Item Title">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <h6 class="text-uppercase fw-bold fs-6">Item Description</h6>
                                            <div class="col-md-12">
                                                <textarea name="item_description" class="form-group mb-3" id="div_editor1"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-7">
                                                <h6 class="text-uppercase fw-bold ">Set Pricing</h6>
                                                <div class="form-check mb-3 d-flex px-0">
                                                    <input type="checkbox" class="me-2" name="ispcs[]" />
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" name="pcsmin[0]"
                                                            class="form-control pcs-input" placeholder="Min Qty" />
                                                        -
                                                        <input type="number" name="pcsmax[0]"
                                                            class="form-control pcs-input me-2" placeholder="Max Qty" />
                                                    </div>
                                                    <div class="input-group">
                                                        <select name="currency[]"
                                                            style="width: 5rem !important;flex:unset;"
                                                            class="form-select input-group-addon">
                                                            <option value="USD">USD</option>
                                                            <option value="EUR">EUR</option>
                                                        </select>
                                                        <input type="number" step="0.01" name="cost[]"
                                                            class="form-control" placeholder="0.00" />
                                                    </div>
                                                </div>
                                                <div class="form-check mb-3 d-flex px-0">
                                                    <input type="checkbox" class="me-2" name="ispcs[]" />
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" name="pcsmin[1]"
                                                            class="form-control pcs-input" placeholder="Min Qty" />
                                                        -
                                                        <input type="number" name="pcsmax[1]"
                                                            class="form-control pcs-input me-2" placeholder="Max Qty" />
                                                    </div>
                                                    <div class="input-group">
                                                        <select name="currency[]"
                                                            style="width: 5rem !important;flex:unset;"
                                                            class="form-select input-group-addon">
                                                            <option value="USD">USD</option>
                                                            <option value="EUR">EUR</option>
                                                        </select>
                                                        <input type="number" step="0.01" name="cost[]"
                                                            class="form-control" placeholder="0.00" />
                                                    </div>
                                                </div>
                                                <div class="form-check mb-3 d-flex px-0">
                                                    <input type="checkbox" class="me-2" name="ispcs[]" />
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" name="pcsmin[2]"
                                                            class="form-control pcs-input" placeholder="Min Qty" />
                                                        -
                                                        <input type="number" name="pcsmax[2]"
                                                            class="form-control pcs-input me-2" placeholder="Max Qty" />
                                                    </div>
                                                    <div class="input-group">
                                                        <select name="currency[]"
                                                            style="width: 5rem !important;flex:unset;"
                                                            class="form-select input-group-addon">
                                                            <option value="USD">USD</option>
                                                            <option value="EUR">EUR</option>
                                                        </select>
                                                        <input type="number" step="0.01" name="cost[]"
                                                            class="form-control" placeholder="0.00" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-12"></div>

                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-12 my-3">
                                                <div class="d-flex">
                                                    <strong class="me-4">Set Aditional Show Case:</strong>
                                                    <div class="form-check me-3">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="isLimitedOffer" />
                                                            Limited Offers
                                                        </label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="isDailyDeal" />
                                                            Daily Deals
                                                        </label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="isBulkBuy" />
                                                            Bulk Buying
                                                        </label>
                                                    </div>
                                                    <div class="form-check me-3">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="isHotProduct" />
                                                            Hot Product
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 mt-3">
                                                    <div class="form-group mb-2">
                                                        <label for="type" class="form-label fw-bolder ">Duration
                                                        </label>
                                                        <select name="duration" id="duration" class="form-select">
                                                            <option value="7">7 Days</option>
                                                            <option value="10">10 Days</option>
                                                            <option value="21">21 Days</option>
                                                            <option value="28">28 Days</option>
                                                            <option value="30">1 Months</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">

                                                <div class="d-flex ">
                                                    <h5 class="fs-6 fw-bold me-3">Shipping cost settings</h5>

                                                </div>
                                                <div id="shippingFormSection">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row mt-3">
                                                                <div class="col-md-4">
                                                                    <div class="form-group mb-2">
                                                                        <label for="rate_table" class="form-label">Enter
                                                                            Shipping Partner</label>
                                                                        <input type="text" name="shipping_partner"
                                                                            id="shipping_partner" class="form-control">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group mb-2">
                                                                        <label for="shipping_method"
                                                                            class="form-label">Shipping Method</label>
                                                                        <select name="shipping_method"
                                                                            class="form-select">
                                                                            <option value="Standard Shipping">Standard
                                                                                Shipping</option>
                                                                            <option value="Express Shipping">Express
                                                                                Shipping</option>
                                                                            <option value="Overnight Shipping">Overnight
                                                                                Shipping</option>
                                                                            <option value="International Shipping">
                                                                                International Shipping</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- Shipping Table -->
                                                        <div class="col-md-12 mb-3">
                                                            <h6 class="fs-6 fw-bold py-3 pb-1">Set Region Or Country</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr class="align-middle">
                                                                            <th class="col-4">Region</th>
                                                                            <th class="col-4">Country</th>
                                                                            <th class="col-3">Shipping Cost</th>
                                                                            <th class="col">Delete</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="expeditedTableBody">
                                                                        <tr>
                                                                            <td colspan="4">
                                                                                <button type="button"
                                                                                    class="btnsem d-flex align-items-center"
                                                                                    onclick="addRow('expeditedTableBody','expedited')">
                                                                                    <span class="plus-circle"><i
                                                                                            class="fa fa-plus"
                                                                                            aria-hidden="true"></i></span>
                                                                                    <span class="btntext">Add Region /
                                                                                        Country</span>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <style>
                                                            .plus-circle {
                                                                height: 30px;
                                                                width: 30px;
                                                                display: flex !important;
                                                                justify-content: center;
                                                                align-items: center;
                                                                border: 1px dashed #110090;
                                                                border-radius: 50%;
                                                                cursor: pointer !important;
                                                                color: #1e03e9 !important;
                                                            }

                                                            .btnsem {
                                                                outline: none !important;
                                                                border: none !important;
                                                            }

                                                            .btnsem .btntext {
                                                                color: #1e03e9 !important;
                                                                margin-left: 1rem !important;
                                                                font-size: 14px !important;
                                                            }
                                                        </style>

                                                    </div>
                                                </div>
                                                <div class="d-flex ">
                                                    <h5 class="fs-6 fw-bold me-3">Your Settings</h5>

                                                </div>
                                                <div id="yoursetting">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-2">
                                                                <label for="htime" class="form-label">Handling
                                                                    time</label>
                                                                <select name="handling_time" class="form-select">
                                                                    @for ($day = 1; $day <= 10; $day++)
                                                                        <option value="{{ $day }}">
                                                                            {{ $day }} Business day(s)</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <h6 class="fw-bold fs-6 d-none">Item location</h6>
                                                        <div class="col-md-4 d-none">
                                                            <div class="form-group mb-2">
                                                                <label for="htime" class="form-label">Country</label>
                                                                <select name="country_region" id="country_region"
                                                                    class="form-select select-prevent" >
                                                                    <option value="">Select Country</option>
                                                                    @php
                                                                        $sellerCountry = isset(auth()->user()->country)
                                                                            ? auth()->user()->country
                                                                            : '';
                                                                    @endphp
                                                                    @foreach ($regions as $region)
                                                                        <optgroup label="{{ $region->name }}">
                                                                            @if (isset($region->countries))
                                                                                @foreach ($region->countries as $rc)
                                                                                    <option @selected($rc->id == $sellerCountry)
                                                                                        value="{{ $rc->id }}">
                                                                                        {{ $rc->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 d-none">
                                                            <div class="form-group mb-2">
                                                                <label for="" class="form-label">State</label>
                                                                <select name="state_region" id="state_region"
                                                                    class="form-select select-prevent" >
                                                                    <option value="">Select...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 d-none">
                                                            <div class="form-group mb-3">
                                                                <label for="" class="form-label">City</label>
                                                                <input type="text" list="cities" name="city"
                                                                    id="city" class="form-control"
                                                                    value="{{ isset(auth()->user()->city) ? auth()->user()->city : '' }}"
                                                                    placeholder="Enter your city" readonly/>
                                                                <datalist id="cities">

                                                                </datalist>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 d-none">
                                                            <div class="form-group mb-2">
                                                                <label for="" class="form-label">ZIP Code</label>
                                                                <input type="text" name="zip" class="form-control"
                                                                    placeholder="XXCI" readonly
                                                                    value="{{ isset(auth()->user()->zip) ? auth()->user()->zip : '' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-3">
                                                            <h6 class="fw-bold fs-6 d-flex">
                                                                Accept returns
                                                                <div
                                                                    class="form-check mx-2 align-items-center form-switch">
                                                                    <input class="form-check-input" name="isReturnAccept"
                                                                        type="checkbox" role="switch"
                                                                        id="isReturnAccept" checked />
                                                                </div>
                                                            </h6>
                                                            <div class="card py-2">
                                                                <div class="card-body  d-flex justify-content-between">
                                                                    <div class="row w-100">

                                                                        <div class="col-md-3 d-flex align-items-center">
                                                                            <div class="input-check "
                                                                                style="white-space: nowrap">
                                                                                <input type="checkbox" name="buyer_pay"
                                                                                    id="buyer_pay"
                                                                                    class="form-check-input" />
                                                                                <label for="buyer_pay"
                                                                                    class="form-label mb-0">Buyer pay
                                                                                    Return
                                                                                    Cost</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 d-flex align-items-center">
                                                                            <div class="input-check"
                                                                                style="white-space: nowrap">
                                                                                <input type="checkbox" name="seller_pay"
                                                                                    id="seller_pay"
                                                                                    class="form-check-input" />
                                                                                <label for="seller_pay"
                                                                                    class="form-label mb-0">Seller pay
                                                                                    Return
                                                                                    Cost</label>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="col-md-3 d-flex align-items-center justify-content-between">
                                                                            <div class="form-group me-3 w-100">
                                                                                <label for="form-label">Return
                                                                                    Timeline</label>
                                                                                <select class="form-select "
                                                                                    name="return_timeline"
                                                                                    id="return_timeline">
                                                                                    <option value="7">7 Days</option>
                                                                                    <option value="14">14 Days</option>
                                                                                    <option value="21">21 Days</option>
                                                                                    <option value="28">28 Days</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 d-flex align-items-center">
                                                                            <div class="form-group me-3 w-100">
                                                                                <label for="refund">Refund</label>
                                                                                <select class="form-select "
                                                                                    name="refund"
                                                                                    id="refund">
                                                                                    <option value="Money Back">Money Back</option>
                                                                                    <option value="New Item">New Item</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="alertContainer" class="mt-3">

                                                </div>
                                                <button type="submit" class="btn btn-secondary mt-3">
                                                    List & Sell
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('seller-custome-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script>
        const regions_countries = [{
            id: 'worldwide',
            text: 'Worldwide'
        }, ...@json($regions_countries)];
        const countries = @json($countries);
       
        $(document).ready(function() {
            $('#rate_table').on('change', function() {
                if ($(this).val() === 'other') {
                    $('#new_rate_table_input').removeClass('d-none');
                } else {
                    $('#new_rate_table_input').addClass('d-none');
                }
            });
        });

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
                    $('#state_region').empty();
                    // Add each state as an option
                    $('#state_region').append('<option value="">Select State</option>');
                    $.each(response, function(index, state) {
                        var oldState =
                            "{{ isset(auth()->user()->state) ? auth()->user()->state : '' }}";
                        // alert(oldState);
                        if (oldState == state.id) {
                            $('#state_region').append('<option value="' + state.id +
                                '" selected>' + state.name +
                                '</option>');
                            fetchCities(state.id)
                        } else {

                            $('#state_region').append('<option  value="' + state.id + '">' +
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
        $('#country_region').change(function() {
            var countryId = $(this).val();
            if (countryId) {
                fetchStates(countryId);
            } else {
                $('#state_region').empty();
            }
        });
        $('#state_region').change(function() {
            var stateId = $(this).val();
            if (stateId) {
                fetchCities(stateId);
            } else {
                $('#cities').empty();
            }
        });
        if ($('#country_region').val() != "") {
            fetchStates($('#country_region').val());
        }
        let rowIndex = 0;

        function addRow(tableId) {
            const index = rowIndex++;

            const newRow = `<tr>
                               <td>
                                 <div class="d-flex">
                                    <input type="radio" class="me-2" name="rate_type[${index}]" value="region" checked/>
                                    <select class="form-control region-select" name="rate_regions[${index}][]" multiple="multiple"></select>
                                 </div>
                               </td>
                               <td>
                                <div class="d-flex">
                                 <input type="radio" class="me-2" name="rate_type[${index}]" value="country"/>
                                     <select class="form-control w-100 country-select" name="rate_country[${index}]">  
                                        <option value="">Select Country</option>    
                                     </select>
                                  </div>
                               </td>
                               <td><input type="number" class="form-control" placeholder="Enter Cost" name="shipping_cost[${index}]"></td>
                               <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Delete</button></td>
                           </tr>`;

            $('#' + tableId).append(newRow);

            // Initialize select2 for the new row
            const newRegionSelect = $(`[name="rate_regions[${index}][]"]`);
            const newCountrySelect = $(`[name="rate_country[${index}]"]`);

            initializeRegionSelect(newRegionSelect);
            initializeCountrySelect(newCountrySelect);
        }

        function removeRow(button) {
            $(button).closest('tr').remove();
        }

        function initializeRegionSelect(regionSelect) {
            regionSelect.select2({
                data: regions_countries,
                placeholder: "Select Regions"
            });

            regionSelect.on('select2:select', function(e) {
                if (e.params.data.id === 'worldwide') {
                    regionSelect.val(['worldwide']).trigger('change');
                    disableOtherOptions(regionSelect, true);
                }
            });

            regionSelect.on('select2:unselect', function(e) {
                if (e.params.data.id === 'worldwide') {
                    disableOtherOptions(regionSelect, false);
                }
            });
        }

        function disableOtherOptions(selectElement, disable) {
            selectElement.find('option').each(function() {
                if ($(this).val() !== 'worldwide') {
                    $(this).prop('disabled', disable);
                }
            });
            selectElement.select2('destroy').select2({
                data: regions_countries,
                placeholder: "Select Regions"
            });
        }

        function initializeCountrySelect(countrySelect) {
            countrySelect.select2({
                data: countries,
                width: "100%",
                placeholder: "Select Countries"
            });
        }

        // Initialize select2 on page load for any existing select elements
        $(document).ready(function() {
            $('.region-select').each(function() {
                initializeRegionSelect($(this));
            });
            $('.country-select').each(function() {
                initializeCountrySelect($(this));
            });
        });
    </script>
    <script>
        // $('#country_region').select2({
        //     width: "100%",
        //     placeholder: "Select Country",
        // });
         $(document).ready(function () {
                function preventSelect() {
                  $('.select-prevent').on('mousedown focus', function (e) {
                     e.preventDefault(); // Prevent interaction
                  });
                }
                preventSelect();
         });
    </script>
    <script>
        var editor1 = new RichTextEditor("#div_editor1");
    </script>
    <script>
        let imagesArray = [];
        $(document).ready(function() {
            const maxImages = 4;


            function updateImageCount() {
                $('#imageCount').text(`${imagesArray.length} of ${maxImages} Photos`);
            }

            // Add Image Preview
            function addImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = $(`
                <div class="preview-img" data-file-name="${file.name}" style="width: 100px; height: 100px; position: relative; margin: 5px;">
                    <img src="${e.target.result}" alt="image preview" style="width: 100%; height: 100%; object-fit: cover;" />
                    <span class="delete-icon" style="position: absolute; top: -7%; right: -7%; cursor: pointer; color: red;">
                        <i class="fa-solid fa-trash text-light"></i>
                    </span>
                </div>
            `);

                    // Bind delete event to the delete icon
                    previewDiv.find('.delete-icon').on('click', function() {
                        removeImage(file.name);
                    });

                    $('#imagePreview').append(previewDiv);
                    imagesArray.push(file);
                    updateImageCount();
                    toggleImageInput();
                };
                reader.readAsDataURL(file);
            }

            // Toggle Image Input Based on Max Limit
            function toggleImageInput() {
                $('#images').prop('disabled', imagesArray.length >= maxImages);
            }

            // Remove Image
            function removeImage(fileName) {

                imagesArray = imagesArray.filter(file => file.name !== fileName);

                renderPreviews();
            }

            // Render Previews
            function renderPreviews() {
                $('#imagePreview').empty();
                imagesArray.forEach(file => addImagePreview(file));
                updateImageCount();
                toggleImageInput();
            }

            // Image Drop Area Events
            $('#imageDropArea').on('dragover', function(e) {
                e.preventDefault();
            }).on('drop', function(e) {
                e.preventDefault();
                const files = e.originalEvent.dataTransfer.files;
                addFiles(files);
            });

            // Add Files Function
            function addFiles(files) {
                $.each(files, function(_, file) {
                    if (file.type.startsWith('image/') && imagesArray.length < maxImages) {
                        addImagePreview(file);
                    }
                });
            }


            $('#images').on('change', function(e) {
                const files = e.target.files;
                addFiles(files);
                $(this).val('');
            });

            // Video Input Change Event
            $('#video').on('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('video/')) {
                    addVideoPreview(file);
                }
            });

            // Add Video Preview
            function addVideoPreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#videoPreview').html(`
                <video controls width="100%">
                    <source src="${e.target.result}" type="${file.type}">
                    Your browser does not support the video tag.
                </video>
            `);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#add_product_form').on('submit', function(e) {
                e.preventDefault();

                // Show overlay and disable submit button
                $('#loadingOverlay').show();
                $(this).find(':submit').prop('disabled', true);

                // Clear any existing alerts
                $('#alertContainer').html('');

                var formData = new FormData(this);
                imagesArray.forEach((file, index) => {
                    formData.append('images[]', file);
                });

                $.ajax({
                    url: '{{ route('seller.store.product') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Show success message and reload page
                            alert('Successfully list your product');
                            location.href = "{{ route('seller.get.products') }}";
                        } else {
                            // Display error message in Bootstrap alert if there's an error
                            $('#alertContainer').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                             <i class="fa-solid fa-circle-exclamation flex-shrink-0 me-2" ></i> Error.
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status == 422) {
                            var errors = xhr.responseJSON.error;
                            var errorMessages = '';
                            // Collect all validation errors into a single alert message
                            $.each(errors, function(key, value) {
                                errorMessages += `<li>${value[0]}</li>`;
                            });
                            // console.log(errorMessages);

                            // Display the validation errors in a Bootstrap alert
                            $('#alertContainer').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                               <i class="fa-solid fa-circle-exclamation flex-shrink-0 me-2" ></i> Validations failed!
                                <ul>${errorMessages}</ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        } else {
                            console.log(xhr);
                        }
                    },
                    complete: function() {
                        // Hide overlay and re-enable submit button
                        $('#loadingOverlay').hide();
                        $('#add_product_form').find(':submit').prop('disabled', false);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to add a new row
            $(".add-row").on("click", function() {
                const index = $("#itemRows .row").length;
                const newRow = `
          <div class="row align-items-center mb-3">
            <div class="col-auto">
              <input type="checkbox" class="form-check-input" name="data_atr[${index}]" />
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Color" name="color_atr[${index}]">
            </div>
            -
            <div class="col">
              <input type="text" class="form-control" placeholder="Size" name="size_atr[${index}]">
            </div>
            -
            <div class="col">
              <input type="number" class="form-control" placeholder="Quantity" name="quantity_atr[${index}]">
            </div>
            <div class="col-auto">
                <a href="javaScript:void(0)" class="text-danger remove-row">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </div>
          </div>`;
                $("#itemRows").append(newRow);
                updateRowIndexes();
            });

            // Function to remove a row
            $("#itemRows").on("click", ".remove-row", function() {
                $(this).closest(".row").remove();
                updateRowIndexes();
            });

            function updateRowIndexes() {
                $("#itemRows .row").each(function(index) {
                    $(this).find("input[type='checkbox']").attr("name", `data_atr[${index}]`);
                    $(this).find("input[placeholder='Color']").attr("name", `color_atr[${index}]`);
                    $(this).find("input[placeholder='Size']").attr("name", `size_atr[${index}]`);
                    $(this).find("input[placeholder='Quantity']").attr("name", `quantity_atr[${index}]`);
                });
            }
        });
    </script>
@endsection
