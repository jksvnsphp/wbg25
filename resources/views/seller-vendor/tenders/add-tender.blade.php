@extends('seller-vendor.seller-frame')

@section('seller-main-content')
<style>
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

    .list-group::-webkit-scrollbar {
        display: none;
    }

    .list-group {
        scrollbar-width: none;
    }

    .list-group {
        overflow-y: auto;
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

    .delete-gimage {
        display: none;
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
            <div class="d-flex justify-content-between flex-wrap align-items-center">
                <h6 class="fs-5 text-light pe-0">Add Tender</h6>
                <h6 class="py-3 fs-5 text-light ">
                    Your Tender upload limit:
                    <span class="badge bg-secondary">{{ $listedTender }}/{{ $listingLimit }}</span>
                </h6>
                <h6 class="px-5 mx-4"></h6>
            </div>
            <form method="post" id="add_my_tender" enctype="multipart/form-data" class="card shadow rounded-0">
                @csrf
                <div class="card-body">
                    <div class="row">
                        @livewire('category-suggestion-tender')
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="title" class="form-label">Add Title
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Enter your Tender Title" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="type" class="form-label">Quantity
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <input type="number" name="quantity" value="{{old('quantity')}}" placeholder="Enter quantity" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="price" class="form-label">Price
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <div class="input-group">
                                            <select name="currency_type" id="currency_type" class="form-control form-select  input-group-btn " style="max-width:5rem !important;">
                                                <option value="usd" @selected(old('currency_type')=='usd' )>USD</option>
                                                <option value="eur" @selected(old('currency_type')=='eur' )>EUR</option>
                                            </select>
                                            <input type="number" step="0.00" name="price" id="price"
                                                class="form-control" placeholder="Enter price" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="type" class="form-label">Condition
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <select name="tender_condition" id="condition" class="form-select">
                                            <option value="BrandNew">Brand New</option>
                                            <option value="NewWithTags">New with tags</option>
                                            <option value="NewWithoutTags">New without tags</option>
                                            <option value="BStock">B-Stock</option>
                                            <option value="PreOwned">Pre-Owned</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="type" class="form-label">Duration
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
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
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-9 my-3">
                            <div class="form-group mb-2">
                                <label for="div_editor1" class="form-label">Add Description
                                    <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                        aria-hidden="true"></i></label>
                                <textarea name="description" id="div_editor1" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-9 mt-4">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image1" class="form-label">Image 1
                                                <small class="text-danger">(500px X 500px) <i class="fa fa-asterisk text-secondary" style="font-size:10px;" aria-hidden="true"></i></small>
                                            </label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_1"
                                                id="img1"
                                                data-preview="#preview_img1"
                                                data-remove="#remove_img1"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="preview_img1" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    id="remove_img1"
                                                    class="btn btn-danger btn-sm"
                                                    style="position:absolute;top:5px;right:5px;display:none;">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image2" class="form-label">Image 2
                                                <small class="text-danger">(500px X 500px)</small>
                                            </label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_2"
                                                id="img2"
                                                data-preview="#preview_img2"
                                                data-remove="#remove_img2"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="preview_img2" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    id="remove_img2"
                                                    class="btn btn-danger btn-sm"
                                                    style="position:absolute;top:5px;right:5px;display:none;">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image3" class="form-label">Image 3 <small class="text-danger">(500px X 500px)</small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_3"
                                                id="img3"
                                                data-preview="#preview_img3"
                                                data-remove="#remove_img3"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="preview_img3" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    id="remove_img3"
                                                    class="btn btn-danger btn-sm"
                                                    style="position:absolute;top:5px;right:5px;display:none;">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image4" class="form-label">Image 4 <small class="text-danger">(500px X 500px)</small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_4"
                                                id="img4"
                                                data-preview="#preview_img4"
                                                data-remove="#remove_img4"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="preview_img4" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    id="remove_img4"
                                                    class="btn btn-danger btn-sm"
                                                    style="position:absolute;top:5px;right:5px;display:none;">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image5" class="form-label">Image 5 <small class="text-danger">(500px X 500px)</small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_5"
                                                id="img5"
                                                data-preview="#preview_img5"
                                                data-remove="#remove_img5"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="preview_img5" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    id="remove_img5"
                                                    class="btn btn-danger btn-sm"
                                                    style="position:absolute;top:5px;right:5px;display:none;">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image6" class="form-label">Image 6 <small class="text-danger">(500px X 500px)</small> </label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_6"
                                                id="img6"
                                                data-preview="#preview_img6"
                                                data-remove="#remove_img6"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png" id="preview_img6" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    id="remove_img6"
                                                    class="btn btn-danger btn-sm"
                                                    style="position:absolute;top:5px;right:5px;display:none;">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex ">
                                <h5 class="fs-6 fw-bold me-3">Shipping settings</h5>
                            </div>
                            <div id="shippingFormSection">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label for="rate_table" class="form-label">Enter
                                                        Shipping Partner</label>
                                                    <input type="text" name="shipping_partner" id="shipping_partner" class="form-control">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label for="shipping_method" class="form-label">Shipping
                                                        Method</label>
                                                    <select name="shipping_method" class="form-select">
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
                                    <div class="col-md-8 mb-3">
                                        <h6 class="fs-6 fw-bold py-3 pb-1">Set Shipping Cost</h6>
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
                                                                <span class="plus-circle"><i class="fa fa-plus"
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
                                    <div class="col-md-4">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <h6 class="fw-bold mb-3">How to set Shipping Cost</h6>

                                                <div class="ratio ratio-16x9">

                                                    <video
                                                        controls
                                                        preload="metadata"
                                                        style="width:100%; border-radius:6px;">
                                                        <source src="{{ asset('uploads/member_packages/How-to-set-Shipping-Cost.mp4') }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>

                                                <small class="text-muted d-block mt-2">
                                                    Watch this video to understand region & country based shipping
                                                </small>
                                            </div>
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
                            <div id="yoursetting" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
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
                                    <div class="col-12 d-none">
                                        <h6 class="fw-bold fs-6">Tender location</h6>
                                        <div class="row">
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
                                                                {{ $rc->name }}
                                                            </option>
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
                                        </div>
                                    </div>
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
                            <div id="alertContainer" class="mt-3">

                            </div>
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-secondary" type="submit">Post Tender</button>
                        </div>
                    </div>
                </div>
            </form>
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
    $(document).ready(function() {
        $('#div_editor1').summernote({
            placeholder: 'Write your Item Description...',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['codeview', 'help']]
            ]
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#add_my_tender').on('submit', function(e) {
            e.preventDefault();
            $('#loadingOverlay').show();
            $(this).find(':submit').prop('disabled', true);
            $('#alertContainer').html('');

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("seller.store.tender") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        // Show success message and reload page
                        toastr.success('Successfully publish your tender.');
                        location.href = response?.url;
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
                    $('#add_my_tender').find(':submit').prop('disabled', false);
                }
            });
        });
    });
</script>

<script>
    const regions_countries = [{
        id: 'worldwide',
        text: 'Worldwide'
    }, ...@json($regions_countries)];
    const countries = @json($countries);



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

    function addRow2(tableId) {
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
                           <td>
                            <div class="input-group">
                               <span class="input-group-text">
                                 US $
                               </span>
                              <input type="number" class="form-control" placeholder="Enter Cost" name="shipping_cost[${index}]">
                             </div>
                           </td>
                           <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Delete</button></td>
                       </tr>`;

        $('#' + tableId).append(newRow);

        // Initialize select2 for the new row
        const newRegionSelect = $(`[name="rate_regions[${index}][]"]`);
        const newCountrySelect = $(`[name="rate_country[${index}]"]`);

        initializeRegionSelect(newRegionSelect);
        initializeCountrySelect(newCountrySelect);
    }

    function addRow(tableId) {
        const index = rowIndex++;
        const cost = "";
        const newRow = `<tr>
        <td>
            <div class="d-flex">
                <input type="radio" class="me-2" name="rate_type[${index}]" value="region" checked/>
                <select class="form-control region-select" name="rate_regions[${index}][]" multiple data-index="${index}"></select>
            </div>
        </td>
        <td>
            <div class="d-flex">
                <input type="radio" class="me-2" name="rate_type[${index}]" value="country"/>
                <select class="form-control w-100 country-select" name="rate_country[${index}]" data-index="${index}">  
                    <option value="">Select Country</option>    
                </select>
            </div>
        </td>
        <td>
            <div class="input-group">
                <select name="currency[${index}]" style="width: 5rem !important;flex:unset;" class="form-select input-group-addon">
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
                <input type="number" class="form-control" placeholder="Enter Cost" name="shipping_cost[${index}]" value="${cost}" step="0.01" min="0">
            </div>
            <small class="text-danger mt-2">Set 0 if shipping cost free</small>
        </td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Delete</button></td>
    </tr>`;

        $('#' + tableId).append(newRow);

        const regionSelect = $(`[name="rate_regions[${index}][]"]`);
        const countrySelect = $(`[name="rate_country[${index}]"]`);

        initializeRegionSelect(regionSelect);
        initializeCountrySelect(countrySelect);


        regionSelect.on('change', function() {
            const selectedRegions = $(this).val();
            console.log(selectedRegions);
            const filteredCountries = countries.filter(function(c) {
                return selectedRegions.includes(c.region_id.toString());
            });

            countrySelect.empty().append(`<option value="">Select Country</option>`);
            filteredCountries.forEach(country => {
                countrySelect.append(`<option value="${country.id}">${country.text}</option>`);
            });

            countrySelect.select2({
                width: "100%",
                placeholder: "Select Country"
            });
        });
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
    document.addEventListener('DOMContentLoaded', function() {

        const REQUIRED_WIDTH = 500;
        const REQUIRED_HEIGHT = 500;
        const MAX_SIZE_MB = 2;

        let requiredImageValid = false;

        document.querySelectorAll('.file-input').forEach(input => {

            const preview = document.querySelector(input.dataset.preview);
            const remove = document.querySelector(input.dataset.remove);
            const required = input.dataset.required === 'true';

            input.addEventListener('change', function() {

                clearError(input);
                hidePreview();

                const file = this.files[0];
                if (!file) {
                    if (required) requiredImageValid = false;
                    return;
                }

                if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                    fail(`Image size must not exceed ${MAX_SIZE_MB}MB.`);
                    return;
                }

                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    fail('Only JPG or PNG images are allowed.');
                    return;
                }

                const img = new Image();
                img.onload = () => {

                    // if (img.width !== REQUIRED_WIDTH || img.height !== REQUIRED_HEIGHT) {
                    //     fail(`Invalid image size. Use ${REQUIRED_WIDTH}×${REQUIRED_HEIGHT}px.`);
                    //     return;
                    // }

                    preview.src = img.src;
                    preview.style.display = 'block';
                    remove.style.display = 'block';

                    if (required) requiredImageValid = true;
                };

                img.src = URL.createObjectURL(file);

                function fail(message) {
                    showError(input, message);
                    input.value = '';
                    if (required) requiredImageValid = false;
                }
            });

            remove.addEventListener('click', () => {
                input.value = '';
                hidePreview();
                clearError(input);
                if (required) requiredImageValid = false;
            });

            function hidePreview() {
                preview.src = '';
                preview.style.display = 'none';
                remove.style.display = 'none';
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            if (!requiredImageValid) {
                e.preventDefault();
                alert('Certificate Image 1 is required and must be valid (500 × 500).');
            }
        });

        function showError(input, message) {
            const error = document.createElement('small');
            error.className = 'text-danger image-error d-block mt-1';
            error.innerText = message;
            input.closest('.card-body').appendChild(error);
        }

        function clearError(input) {
            const error = input.closest('.card-body').querySelector('.image-error');
            if (error) error.remove();
        }
    });
</script>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId)
                    .attr('src', e.target.result)
                    .show()
                    .siblings('.delete-gimage')
                    .show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Image change handlers
    for (let i = 1; i <= 6; i++) {
        $('#imgold' + i).on('change', function() {
            previewImage(this, 'preview' + i);
        });
    }

    // Delete image
    $('.delete-gimage').on('click', function() {
        let previewId = $(this).data('preview');
        let inputId = $(this).data('input');

        $('#' + previewId).attr('src', '').hide();
        $('#' + inputId).val(''); // Clear file input
        $(this).hide();
    });
</script>


@endsection