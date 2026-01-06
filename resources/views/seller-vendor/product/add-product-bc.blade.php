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
    </style>
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div class="spinner-border text-light" role="status"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
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
                            <div class="col-md-9">


                                {{-- <div class="col-12 d-none">
                                    <div class="row" id="category_container">
                                        <div class="col-md-4 mb-3">
                                            <label for="category" class="form-label fw-bold text-primary">Category</label>
                                            <select name="category" id="category_level1" class="form-select">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div id="required_attribute_container" class="col-12">

                                    </div>

                                    <div id="attribute_container" class="col-12 mt-4">

                                    </div>
                                </div>
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
                                                <textarea name="product_description" class="form-group mb-3" id="div_editor1"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-7">
                                                <h6 class="text-uppercase fw-bold ">Set Pricing</h6>
                                                <div class="form-check mb-3 d-flex px-0">
                                                    <input type="checkbox" class="me-2" name="ispcs[]" />
                                                    <input type="text" name="pcs[]" class="form-control pcs-input me-2"
                                                        placeholder="e.g., 1-10 pcs" />
                                                    <div class="input-group">
                                                        <select name="currency[]" style="width: 5rem !important;flex:unset;"
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
                                                    <input type="text" name="pcs[]"
                                                        class="form-control pcs-input me-2"
                                                        placeholder="e.g., 1-10 pcs" />
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
                                                    <input type="text" name="pcs[]"
                                                        class="form-control pcs-input me-2"
                                                        placeholder="e.g., 1-10 pcs" />
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
                                            <div class="col-md-7">
                                                <div
                                                    class="form-group mt-2 d-flex align-items-center flex-sm-nowrap flex-wrap">
                                                    <label for="totalQty" class="form-label fw-bold mb-sm-0 mb-2 me-2"
                                                        style="white-space:nowrap">Total Qty</label>
                                                    <input type="number" name="totalQty" id="totalQty"
                                                        class="form-control" placeholder="Enter Quantity">
                                                </div>
                                            </div>
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
                                                    <h5 class="fs-6 fw-bold me-3">Shipping settings</h5>
                                                    {{-- <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="flexSwitchCheckChecked" name="isRateTable" checked>
                                                    </div> --}}
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
                                                                            <th class="col-5">Region</th>
                                                                            <th class="col">Country</th>
                                                                            <th class="col">Cost</th>
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
                                                    {{-- <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="isYourSetting" name="isYourSetting" checked>
                                                    </div> --}}
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
                                                        <h6 class="fw-bold fs-6">Item location</h6>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-2">
                                                                <label for="htime" class="form-label">Country</label>
                                                                <select name="country_region" id="country_region"
                                                                    class="form-select">
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
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-2">
                                                                <label for="" class="form-label">State</label>
                                                                <select name="state_region" id="state_region"
                                                                    class="form-select">
                                                                    <option value="">Select...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-3">
                                                                <label for="" class="form-label">City</label>
                                                                <input type="text" list="cities" name="city"
                                                                    id="city" class="form-control"
                                                                    value="{{ isset(auth()->user()->city) ? auth()->user()->city : '' }}"
                                                                    placeholder="Enter your city" />
                                                                <datalist id="cities">

                                                                </datalist>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-2">
                                                                <label for="" class="form-label">ZIP Code</label>
                                                                <input type="text" name="zip" class="form-control"
                                                                    placeholder="XXCI"
                                                                    value="{{ isset(auth()->user()->zip) ? auth()->user()->zip : '' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h6 class="fw-bold fs-6">Returns</h6>
                                                            <div class="card py-2">
                                                                <div class="card-body  d-flex justify-content-between">
                                                                    <div class="row w-100">
                                                                        <div class="col-md-3 d-flex align-items-center">
                                                                            <div>
                                                                                <h6 class="fs-6 fw-bolder mb-0 pb-0">Accept
                                                                                    returns
                                                                                </h6>
                                                                                <p class="text-muted mb-0 pb-0"
                                                                                    style="font-size: 12px !important">
                                                                                    Allow returns for items
                                                                                </p>
                                                                            </div>
                                                                        </div>
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
                                                                            <div class="form-group me-3"
                                                                                style="width: 8rem;">
                                                                                <label for="form-label">Return
                                                                                    Timeline</label>
                                                                                <select class="form-control "
                                                                                    name="return_timeline"
                                                                                    id="return_timeline">
                                                                                    <option value="7">7 Days</option>
                                                                                    <option value="14">14 Days</option>
                                                                                    <option value="21">21 Days</option>
                                                                                    <option value="28">28 Days</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="mt-3">
                                                                                <div class="form-check  form-switch">
                                                                                    <input class="form-check-input"
                                                                                        name="isReturnAccept"
                                                                                        type="checkbox" role="switch"
                                                                                        id="isReturnAccept" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.pcs-input').mask('000-0000 pcs', {
                translation: {
                    '0': {
                        pattern: /[0-9]/
                    }
                },
                placeholder: "001-0010 pcs"
            });
            $('.pcs-input').on('blur', function() {
                const inputVal = $(this).val();
                const isValid = /^[0-9]{1,4}-[0-9]{1,4}\s*pcs$/.test(inputVal);
                if (!isValid) {
                    alert("Please enter a valid range format, e.g., '1-10 pcs' or '11-100 pcs'.");
                    $(this).css('border-color', 'red');
                } else {
                    $(this).css('border-color', '');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // When parent category is selected
            $('#category_level1').change(function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '{{ route('seller.get.subcategory') }}', // Route to fetch subcategories
                        type: 'POST',
                        data: {
                            category_id: categoryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.length > 0) {
                                $('#category_container').find('#category_level22')
                                    .remove();
                                $('#category_container').find('#category_level33')
                                    .remove();
                                $('#category_container').find('#category_level44')
                                    .remove();

                                var subcategoryHtml =
                                    '<div class="col-md-4 mb-3" id="category_level22">' +
                                    '<label for="subcategory" class="form-label fw-bold text-primary">Sub Category</label>' +
                                    '<select name="subcategory" id="category_level2" class="form-select">' +
                                    '<option value="">Select Sub Category</option>';
                                $.each(response, function(index, subCategory) {
                                    subcategoryHtml += '<option value="' + subCategory
                                        .id + '">' + subCategory.name + '</option>';
                                });
                                subcategoryHtml += '</select></div>';
                                $('#category_container').append(
                                    subcategoryHtml);
                            }
                        }
                    });
                }
            });

            // When subcategory is selected
            $(document).on('change', '#category_level2', function() {
                $('#required_attribute_container').empty();
                $('#attribute_container').empty();

                var subCategoryId = $(this).val();
                if (subCategoryId) {
                    $.ajax({
                        url: '{{ route('seller.get.subsubcategory') }}',
                        type: 'POST',
                        data: {
                            sub_category_id: subCategoryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.length > 0) {
                                $('#category_container').find('#category_level33').remove();
                                $('#category_container').find('#category_level44').remove();

                                var subSubCategoryHtml =
                                    '<div class="col-md-4 mb-3" id="category_level33">' +
                                    '<label for="subsubcategory" class="form-label fw-bold text-primary">Child Category</label>' +
                                    '<select name="childcategory" id="category_level3" class="form-select">' +
                                    '<option value="">Select Child Category</option>';
                                $.each(response, function(index, subSubCategory) {
                                    subSubCategoryHtml += '<option value="' +
                                        subSubCategory.id + '">' + subSubCategory.name +
                                        '</option>';
                                });
                                subSubCategoryHtml += '</select></div>';
                                $('#category_container').append(subSubCategoryHtml);
                            }
                        }
                    });

                    $.ajax({
                        url: '{{ route('seller.get.category.attributes') }}',
                        type: 'POST',
                        data: {
                            category_id: subCategoryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.length > 0) {
                                $('#required_attribute_container').find(
                                    '#rq_category_attributes').remove();
                                $('#attribute_container').find('#category_attributes').remove();

                                var rqattributeHtml =
                                    `<div class="col-md-12 mb-3" id="re_category_attributes">
                            <label for="attributes" class="form-label fw-bold text-primary d-flex justify-content-between">
                                Attributes (Required)
                            </label>
                            <div id="requiredAttributesContent">`;

                                var attributeHtml =
                                    `<div class="col-md-12 mb-3" id="category_attributes">
                            <label for="attributes" class="form-label fw-bold text-primary d-flex justify-content-between">
                                Attributes (Optional)
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="optionalToggle" checked>
                                </div>
                            </label>
                            <div id="optionalAttributesContent">`;

                                $.each(response, function(index, attribute) {
                                    var attributeRowHtml = `
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="fs-6 fw-bold text-decoration-underline">${attribute.name}</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">`;

                                    if (attribute.input_option === 'text') {
                                        attributeRowHtml +=
                                            `<input ${attribute.isRequired ? 'required' : ''} type="text" name="attributesData[${attribute.id}]" class="form-control" placeholder="Enter ${attribute.name}">`;
                                    } else if (attribute.input_option === 'select') {
                                        attributeRowHtml +=
                                            `<select ${attribute.isRequired ? 'required' : ''} name="attributesData[${attribute.id}]" class="form-select">`;
                                        $.each(attribute.items, function(i, item) {
                                            attributeRowHtml +=
                                                `<option value="${item.id}">${item.attribute_option}</option>`;
                                        });
                                        attributeRowHtml += '</select>';
                                    } else if (attribute.input_option === 'checkbox' ||
                                        attribute.input_option === 'radio') {
                                        $.each(attribute.items, function(i, item) {
                                            attributeRowHtml += `
                                    <div class="form-check">
                                        <input ${attribute.isRequired ? 'required' : ''} type="${attribute.input_option}" name="attributesData[${attribute.id}]${attribute.input_option === 'checkbox' ? '[]' : ''}" value="${item.id}" class="form-check-input">
                                        <label class="form-check-label">${item.attribute_option}</label>
                                    </div>`;
                                        });
                                    }

                                    attributeRowHtml += '</div></div></div>';
                                    if (attribute.isRequired) {
                                        rqattributeHtml += attributeRowHtml;
                                    } else {
                                        attributeHtml += attributeRowHtml;
                                    }
                                });

                                rqattributeHtml +=
                                    '</div></div>'; // Close required content div and container div
                                attributeHtml +=
                                    '</div></div>'; // Close optional content div and container div
                                $('#attribute_container').append(attributeHtml);
                                $('#required_attribute_container').append(rqattributeHtml);

                                $('#optionalToggle').change(function() {
                                    var isEnabled = $(this).is(':checked');
                                    $('#optionalAttributesContent').toggle(isEnabled);
                                });

                                $('#requiredToggle').trigger('change');
                                $('#optionalToggle').trigger('change');
                            }
                        }
                    });
                }
            });

            // When sub-subcategory is selected
            $(document).on('change', '#category_level3', function() {
                var subSubCategoryId = $(this).val();
                if (subSubCategoryId) {
                    $.ajax({
                        url: '{{ route('seller.get.childcategory') }}',
                        type: 'POST',
                        data: {
                            sub_sub_category_id: subSubCategoryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.length > 0) {
                                $('#category_container').find('#category_level44')
                                    .remove(); // Remove previous level 4 if exists

                                var childCategoryHtml =
                                    '<div class="col-md-4 mb-3" id="category_level44">' +
                                    '<label for="childcategory" class="form-label fw-bold text-primary">End Category</label>' +
                                    '<select name="endcategory" id="category_level4" class="form-select">' +
                                    '<option value="">Select End Category</option>';
                                $.each(response, function(index, childCategory) {
                                    childCategoryHtml += '<option value="' +
                                        childCategory.id + '">' + childCategory.name +
                                        '</option>';
                                });
                                childCategoryHtml += '</select></div>';
                                $('#category_container').append(
                                    childCategoryHtml); // Append to category_container
                            }
                        }
                    });
                }
            });
        });


        const regions_countries = [{
            id: 'worldwide',
            text: 'Worldwide'
        }, ...@json($regions_countries)];
        const countries = @json($countries);
        $(document).ready(function() {
            // Toggle shipping form section
            $('#flexSwitchCheckChecked').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#shippingFormSection').slideDown(500);
                } else {
                    $('#shippingFormSection').slideUp(500);
                }
            });
            $('#isYourSetting').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#yoursetting').slideDown(500);
                } else {
                    $('#yoursetting').slideUp(500);
                }
            });
        });
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
                                    <input type="radio" class="me-2" name="rate_type[${index}]" value="region"/>
                                    <select class="form-control region-select" name="rate_regions[${index}][]" multiple="multiple"></select>
                                 </div>
                               </td>
                               <td>
                                <div class="d-flex">
                                 <input type="radio" class="me-2" name="rate_type[${index}]" value="country"/>
                                     <select class="form-control w-100 country-select" name="rate_country[${index}][]">  
                                        <option value="">Select Country</option>    
                                     </select>
                                  </div>
                               </td>
                               <td><input type="text" class="form-control" placeholder="Enter Cost" name="cost[${index}][]"></td>
                               <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Delete</button></td>
                           </tr>`;

            $('#' + tableId).append(newRow);

            // Initialize select2 for the new row
            const newRegionSelect = $(`[name="rate_regions[${index}][]"]`);
            const newCountrySelect = $(`[name="rate_country[${index}][]"]`);

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
        $('#country_region').select2({
            width: "100%",
            placeholder: "Select Country",
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
                            toastr.success(response.message);
                            location.reload(true);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, response) {
                        if (xhr.status == 422) {
                            var errors = xhr.responseJSON.error;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
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
@endsection
