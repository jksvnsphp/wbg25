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
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
        <img src="{{ asset('uploads/loading-gif.gif') }}" class="h-100 w-100" alt="">
    </div>
</div>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-2 bg-primary py-3">
            <h6 class="fs-5 text-light py-3 px-3">Edit Tender</h6>

            <form method="post" id="edit_my_tender" enctype="multipart/form-data" class="card shadow rounded-0">
                @csrf
                <div class="card-body">
                    <div class="row">

                        @livewire('category-suggestion-tender', [
                        'searchTerm' => $tender->searched_category,
                        'hasPath' => $tender->searched_path,
                        'parentCategoryId' => $tender->parent_category_id,
                        'categoryId' => $tender->category_id,
                        'childCategoryId' => $tender->subcategory_id,
                        'endChildCategoryId' => $tender->childcategory_id,
                        ])
                    </div>
                    <input type="hidden" name="id" value="{{ $tender->id }}">
                    <div class="row mt-4">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="title" class="form-label">Add Title
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Enter your Tender Title" value="{{ $tender->name }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="type" class="form-label">Quantity
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <input type="number" name="quantity" value="{{old('quantity',$tender->quantity ?? 1)}}" placeholder="Enter quantity" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="price" class="form-label">Price
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <div class="input-group">
                                            <select name="currency_type" id="currency_type"
                                                class="form-control form-select  input-group-btn "
                                                style="max-width:5rem !important;">
                                                <option value="usd" @selected($tender->currency == 'usd')>USD</option>
                                                <option value="eur" @selected($tender->currency == 'eur')>EUR</option>
                                            </select>
                                            <input type="number" step="0.00" name="price" id="price"
                                                class="form-control" placeholder="Enter price"
                                                value="{{ $tender->price }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="type" class="form-label">Condition
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <select name="tender_condition" id="condition" class="form-select">
                                            <option @selected($tender->tender_condition == 'BrandNew') value="BrandNew">Brand New</option>
                                            <option @selected($tender->tender_condition == 'NewWithTags') value="NewWithTags">New with tags
                                            </option>
                                            <option @selected($tender->tender_condition == 'NewWithoutTags') value="NewWithoutTags">New without tags
                                            </option>
                                            <option @selected($tender->tender_condition == 'BStock') value="BStock">B-Stock</option>
                                            <option @selected($tender->tender_condition == 'PreOwned') value="PreOwned">Pre-Owned</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="type" class="form-label">Duration
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <select name="duration" id="duration" class="form-select">
                                            <option @selected($tender->duration == '7') value="7">7 Days</option>
                                            <option @selected($tender->duration == '10') value="10">10 Days</option>
                                            <option @selected($tender->duration == '21') value="21">21 Days</option>
                                            <option @selected($tender->duration == '28') value="28">28 Days</option>
                                            <option @selected($tender->duration == '30') value="30">1 Months</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="div_editor1" class="form-label">Add Description
                                            <i class="fa fa-asterisk text-secondary" style="font-size:10px;"
                                                aria-hidden="true"></i></label>
                                        <textarea name="description" id="div_editor1" class="form-control" rows="3">{{ $tender->description }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-9">
                            <h6 class="fw-bold my-3">Tender Gallery</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image1" class="form-label">Image 1 <small class="text-danger">(480px X 360px) <i class="fa fa-asterisk text-secondary" style="font-size:10px;" aria-hidden="true"></i></small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_1"
                                                id="image1"
                                                data-preview="#preview_img1"
                                                data-remove="#remove_img1"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                @php
                                                $src1 = (!empty($tender->image_1))
                                                ? asset('uploads/tender/' . $tender->image_1)
                                                : 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';
                                                @endphp
                                                <img src="{{ $src1 }}" id="preview_img1" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    data-col="image_1"
                                                    data-id="{{ $tender->id ?? null }}"
                                                    id="remove_img1"
                                                    class="btn btn-danger btn-sm removeImg"
                                                    style="position:absolute;top:5px;right:5px;display:{{ !empty($tender->image_1) ? 'block' : 'none' }};">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image2" class="form-label">Image 2 <small class="text-danger">(480px X 360px)</small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_2"
                                                id="image2"
                                                data-preview="#preview_img2"
                                                data-remove="#remove_img2"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                @php
                                                $src2 = (!empty($tender->image_2))
                                                ? asset('uploads/tender/' . $tender->image_2)
                                                : 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';
                                                @endphp
                                                <img src="{{ $src2 }}" id="preview_img2" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    data-col="image_2"
                                                    data-id="{{ $tender->id ?? null }}"
                                                    id="remove_img2"
                                                    class="btn btn-danger btn-sm removeImg"
                                                    style="position:absolute;top:5px;right:5px;display:{{ !empty($tender->image_2) ? 'block' : 'none' }};">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image3" class="form-label">Image 3 <small class="text-danger">(480px X 360px)</small></label>
                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_3"
                                                id="image3"
                                                data-preview="#preview_img3"
                                                data-remove="#remove_img3"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                @php
                                                $src3 = (!empty($tender->image_3))
                                                ? asset('uploads/tender/' . $tender->image_3)
                                                : 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';
                                                @endphp
                                                <img src="{{ $src3 }}" id="preview_img3" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    data-col="image_3"
                                                    data-id="{{ $tender->id ?? null }}"
                                                    id="remove_img3"
                                                    class="btn btn-danger btn-sm removeImg"
                                                    style="position:absolute;top:5px;right:5px;display:{{ !empty($tender->image_3) ? 'block' : 'none' }};">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image4" class="form-label">Image 4 <small class="text-danger">(480px X 360px)</small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_4"
                                                id="image4"
                                                data-preview="#preview_img4"
                                                data-remove="#remove_img4"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                @php
                                                $src4 = (!empty($tender->image_4))
                                                ? asset('uploads/tender/' . $tender->image_4)
                                                : 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';
                                                @endphp
                                                <img src="{{ $src4 }}" id="preview_img4" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    data-col="image_4"
                                                    data-id="{{ $tender->id ?? null }}"
                                                    id="remove_img4"
                                                    class="btn btn-danger btn-sm removeImg"
                                                    style="position:absolute;top:5px;right:5px;display:{{ !empty($tender->image_4) ? 'block' : 'none' }};">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image5" class="form-label">Image 5 <small class="text-danger">(480px X 360px)</small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_5"
                                                id="image5"
                                                data-preview="#preview_img5"
                                                data-remove="#remove_img5"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                @php
                                                $src5 = (!empty($tender->image_5))
                                                ? asset('uploads/tender/' . $tender->image_5)
                                                : 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';
                                                @endphp
                                                <img src="{{ $src5 }}" id="preview_img5" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    data-col="image_5"
                                                    data-id="{{ $tender->id ?? null }}"
                                                    id="remove_img5"
                                                    class="btn btn-danger btn-sm removeImg"
                                                    style="position:absolute;top:5px;right:5px;display:{{ !empty($tender->image_5) ? 'block' : 'none' }};">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <label for="image6" class="form-label">Image 6 <small class="text-danger">(480px X 360px)</small></label>

                                            <input type="file"
                                                class="form-control file-input"
                                                name="image_6"
                                                id="image6"
                                                data-preview="#preview_img6"
                                                data-remove="#remove_img6"
                                                data-required="true">

                                            <div class="position-relative d-inline-block mt-2">
                                                @php
                                                $src6 = (!empty($tender->image_6))
                                                ? asset('uploads/tender/' . $tender->image_6)
                                                : 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Image_not_available.png';
                                                @endphp
                                                <img src="{{ $src6 }}" id="preview_img6" style="height:6rem; border:1px solid #bcbcbc;" class="mt-2 rounded-2" alt="Image_not_available">
                                                <button type="button"
                                                    data-col="image_6"
                                                    data-id="{{ $tender->id ?? null }}"
                                                    id="remove_img6"
                                                    class="btn btn-danger btn-sm removeImg"
                                                    style="position:absolute;top:5px;right:5px;display:{{ !empty($tender->image_6) ? 'block' : 'none' }};">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
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
                                                        id="shipping_partner" class="form-control"
                                                        value="{{ isset($tender->rate_table->shipping_partner) ? $tender->rate_table->shipping_partner : '' }}">

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label for="shipping_method" class="form-label">Shipping
                                                        Method</label>
                                                    <select name="shipping_method" class="form-select">
                                                        <option @selected(isset($tender->rate_table->shipping_method) && $tender->rate_table->shipping_method == 'Standard Shipping')
                                                            value="Standard Shipping">Standard
                                                            Shipping</option>
                                                        <option @selected(isset($tender->rate_table->shipping_method) && $tender->rate_table->shipping_method == 'Express Shipping') value="Express Shipping">
                                                            Express
                                                            Shipping</option>
                                                        <option @selected(isset($tender->rate_table->shipping_method) && $tender->rate_table->shipping_method == 'Overnight Shipping')
                                                            value="Overnight Shipping">Overnight
                                                            Shipping</option>
                                                        <option @selected(isset($tender->rate_table->shipping_method) && $tender->rate_table->shipping_method == 'International Shipping')
                                                            value="International Shipping">
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
                                                @php
                                                $handling_time = isset($tender->tender_setting->handling_time)
                                                ? $tender->tender_setting->handling_time
                                                : 1;
                                                @endphp
                                                @for ($day = 1; $day <= 10; $day++)
                                                    <option @selected($handling_time==$day) value="{{ $day }}">
                                                    {{ $day }} Business day(s)</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <h6 class="fw-bold fs-6 d-none">Item location</h6>
                                    <div class="col-md-4 d-none">
                                        <div class="form-group mb-2">
                                            <label for="htime" class="form-label">Country</label>
                                            <select name="country_region" id="country_region" class="form-select">
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
                                    <div class="col-md-4 d-none">
                                        <div class="form-group mb-2">
                                            <label for="" class="form-label">State</label>
                                            <select name="state_region" id="state_region" class="form-select">
                                                <option value="">Select...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none">
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">City</label>
                                            <input type="text" list="cities" name="city" id="city"
                                                class="form-control"
                                                value="{{ isset(auth()->user()->city) ? auth()->user()->city : '' }}"
                                                placeholder="Enter your city" />
                                            <datalist id="cities">

                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none">
                                        <div class="form-group mb-2">
                                            <label for="" class="form-label">ZIP Code</label>
                                            <input type="text" name="zip" class="form-control"
                                                placeholder="XXCI"
                                                value="{{ isset(auth()->user()->zip) ? auth()->user()->zip : '' }}" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <h6 class="fw-bold fs-6 d-flex">
                                        Accept returns
                                        <div
                                            class="form-check mx-2 align-items-center form-switch">
                                            <input @checked($tender->isReturnAccept==1) class="form-check-input" name="isReturnAccept"
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
                                                        <input @checked($tender->buyer_pay==1) type="checkbox" name="buyer_pay"
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
                                                        <input @checked($tender->seller_pay==1) type="checkbox" name="seller_pay"
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
                                                            <option @selected($tender->return_timeline=="7") value="7">7 Days</option>
                                                            <option @selected($tender->return_timeline=="14") value="14">14 Days</option>
                                                            <option @selected($tender->return_timeline=="21") value="21">21 Days</option>
                                                            <option @selected($tender->return_timeline=="28") value="28">28 Days</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 d-flex align-items-center">
                                                    <div class="form-group me-3 w-100">
                                                        <label for="refund">Refund</label>
                                                        <select class="form-select "
                                                            name="refund"
                                                            id="refund">
                                                            <option @selected($tender->refund=="Money Back") value="Money Back">Money Back</option>
                                                            <option @selected($tender->refund=="New Item") value="New Item">New Item</option>
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
                        <div class="col-md-12">
                            <button class="btn btn-secondary" type="submit">
                                @if($tender->is_expired)
                                {{'Re-list'}}
                                @else
                                {{'Save Changes'}}
                                @endif
                            </button>
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
    document.addEventListener('DOMContentLoaded', function() {

        const REQUIRED_WIDTH = 480;
        const REQUIRED_HEIGHT = 360;
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
                    if (img.width !== REQUIRED_WIDTH || img.height !== REQUIRED_HEIGHT) {
                        fail(`Invalid image size. Use ${REQUIRED_WIDTH}×${REQUIRED_HEIGHT}px.`);
                        return;
                    }

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
                alert('Certificate Image 1 is required and must be valid (480 × 360).');
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
    const shippingRateCosts = <?php echo json_encode($tender->rate_table->shipping_rate_costs); ?>;
    populateRows('expeditedTableBody', shippingRateCosts);

    function populateRows(tableId, shippingRateCosts) {
        shippingRateCosts.forEach(cost => {
            addRow(tableId, cost);
        });
    }

    function addRow(tableId, data = null) {
        const index = rowIndex++;

        const isRegion = data && data.shipping_type === "region";
        const isCountry = data && data.shipping_type === "country";
        const cost = data ? data.cost : "";

        // Check if "worldwide" is selected
        const isWorldwide = isRegion && data.shipping_regions.some(region => region.isWorldwide === 1);
        const selectedRegions = isRegion && data.shipping_regions ?
            isWorldwide ? ['worldwide'] :
            data.shipping_regions.map(region => region.region_id) : [];
        const selectedCountry = isCountry && data.shipping_regions.length > 0 ?
            data.shipping_regions[0].country_id :
            "";

        const newRow =
            `<tr>
        <td>
            <div class="d-flex">
                <input type="radio" class="me-2" name="rate_type[${index}]" value="region" ${isRegion ? "checked" : ""}/>
                <select class="form-control region-select" name="rate_regions[${index}][]" multiple="multiple">
                </select>
            </div>
        </td>
        <td>
            <div class="d-flex">
                <input type="radio" class="me-2" name="rate_type[${index}]" value="country" ${isCountry ? "checked" : ""}/>
                <select class="form-control w-100 country-select" name="rate_country[${index}]">
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
                <input type="number" class="form-control" placeholder="Enter Cost" name="shipping_cost[${index}]" value="${cost}">
            </div>
        </td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Delete</button></td>
     </tr>`;
        $('#' + tableId).append(newRow);

        const newRegionSelect = $(`[name="rate_regions[${index}][]"]`);
        const newCountrySelect = $(`[name="rate_country[${index}]"]`);

        initializeRegionSelect(newRegionSelect);
        initializeCountrySelect(newCountrySelect);

        if (isRegion) {
            newRegionSelect.val(selectedRegions).trigger('change');

            // Disable all other options if "worldwide" is selected
            if (isWorldwide) {
                disableOtherOptions(newRegionSelect, true);
            }
        }

        if (isCountry) {
            newCountrySelect.val(selectedCountry).trigger('change');
        }
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
    $(document).ready(function() {
        $('#edit_my_tender').on('submit', function(e) {
            e.preventDefault();
            $('#loadingOverlay').show();
            $(this).find(':submit').prop('disabled', true);
            $('#alertContainer').html('');
            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("seller.update.tender") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        // Show success message and reload page
                        toastr.success('Successfully updated your tender.');
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
                    $('#edit_my_tender').find(':submit').prop('disabled', false);
                }
            });
        });
    });
</script>

<script>
    $(document).on('click', '.removeImg', function() {
        var id = $(this).data('id');
        var col = $(this).data('col');

        if (confirm("Are you sure you want to delete this image?")) {
            $.ajax({
                url: '{{ route("delete.tender-img") }}',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    column: col
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error("Something went wrong.");
                    }
                }
            });
        }
    });
</script>
@endsection