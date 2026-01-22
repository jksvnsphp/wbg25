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
            <h6 class="fs-5 text-light py-3 px-3">Edit Multiply Listing</h6>

            <div class="card shadow rounded-0">
                <form class="card-body" id="edit_product_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="col-md-9">
                            <h6 class="fw-bold text-primary fs-5">
                                Start your multiply listing and make Money selling on World Business
                                Guide - www.wbg24.com
                            </h6>

                        </div>
                        @php
                        $oldAttributes = isset($product->product_attributes)
                        ? $product->product_attributes->toArray()
                        : [];
                        $extraAttributes = [['name' => '', 'value' => '']];
                        if (
                        isset($product->extraAttributes) &&
                        json_decode($product->extraAttributes) != null
                        ) {
                        $extraAttributes = json_decode($product->extraAttributes);
                        }
                        @endphp
                        @livewire('category-multiply', [
                        'searchTerm' => $product->searched_cat,
                        'hasPath' => $product->searched_path,
                        'parentCategoryId' => $product->parent_category_id,
                        'categoryId' => $product->category_id,
                        'childCategoryId' => $product->subcategory_id,
                        'endChildCategoryId' => $product->childcategory_id,
                        'old_attributes_data' => $oldAttributes,
                        'buyerNeedDetail' => $product->isAttribute == 1 ? true : false,
                        'listType' => $product->isListingType,
                        'specificDetails' => $extraAttributes,
                        'itemCondition' => $product->item_condition,
                        ])
                        <div class="col-md-12">
                            <!-- Add Variant Section -->
                            <div class="row mt-3">
                                <h6 class="text-primary fs-5">Set product characteristics like color, size, or others.
                                </h6>
                                <div class="col-md-10 col-lg-8">
                                    <div class="input-group">
                                        <input type="text" id="newVariantName" class="form-control"
                                            placeholder="Enter Characteristic">
                                        <button id="addVariantBtn" class="btn btn-secondary" type="button" disabled>
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div id="variantList" class="row mt-3"></div>
                                    <button type="button" id="generateCombinationsBtn" class="btn btn-primary mt-3"
                                        style="display: none;">Generate Combinations</button>
                                </div>
                                <div class="col-md-2 col-lg-4 position-relative">
                                    <!-- <img style="border: 3px solid #ff7300;" src="{{ asset('uploads/ppic.png') }}"
                                            class="img-fluid rounded-2" alt=""> -->
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body text-center">
                                            <h6 class="fw-bold mb-3">How to set Characteristic</h6>
                                            <div class="ratio ratio-16x9">
                                                <video
                                                    controls
                                                    preload="metadata"
                                                    style="width:100%; border-radius:6px;">
                                                    <source src="{{ asset('uploads/member_packages/How-to-set-Characteristics.mp4') }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>

                                            <small class="text-muted d-block mt-2">
                                                Watch this video to understand How to set Characteristics
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Combinations Table -->
                            <div id="combinationsTable" class="row mt-5" style="display: none;">
                                <div class="col-md-9">
                                    <h6 class="text-primary">Generated Combinations</h6>
                                    <div class=" table-responsive ">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Combination</th>
                                                    <th>Gallery</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="combinationsBody"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="row justify-content-between">
                                <div class="col-12">
                                    {{-- photos --}}
                                    <div class="row mt-4">
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
                                            <div id="videoPreview" class="mt-2">
                                                @if (isset($product->video->video_url))
                                                <video controls width="100%">
                                                    <source
                                                        src="{{ asset('uploads/products/videos/' . $product->video->video_url) }}"
                                                        type="video/mp4">
                                                    <source
                                                        src="{{ asset('uploads/products/videos/' . $product->video->video_url) }}"
                                                        type="video/ogg">
                                                    Your browser does not support the video tag.
                                                </video>
                                                @endif
                                            </div>
                                            <!-- Video preview will go here -->
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="form-group mt-2 d-flex align-items-center flex-sm-nowrap flex-wrap">
                                                <label for="item_title" class="form-label fw-bold mb-sm-0 md-2 me-2"
                                                    style="white-space: nowrap;">Item Title:</label>
                                                <input type="text" name="item_title" id="item_title"
                                                    class="form-control" placeholder="Enter Item Title"
                                                    value="{{ $product->name }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <h6 class="text-uppercase fw-bold fs-6">Item Description</h6>
                                        <div class="col-md-12">
                                            <textarea name="item_description" class="form-group mb-3" id="div_editor1">{{ $product->description }}</textarea>
                                        </div>
                                    </div>


                                    <div class="row mt-3">
                                        <div class="col-md-12 my-3">
                                            <div class="d-flex">
                                                <strong class="me-4">Set Aditional Show Case:</strong>
                                                <div class="form-check me-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="isLimitedOffer" @checked($product->isLimitedOffer) />
                                                        Limited Offers
                                                    </label>
                                                </div>
                                                <div class="form-check me-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="isDailyDeal" @checked($product->isDailyDeal) />
                                                        Daily Deals
                                                    </label>
                                                </div>
                                                <div class="form-check me-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="isBulkBuy" @checked($product->isBulkBuy) />
                                                        Bulk Buying
                                                    </label>
                                                </div>
                                                <div class="form-check me-3">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="isHotProduct" @checked($product->isHotProduct) />
                                                        Hot Product
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-7 mt-3 d-none">
                                                <div class="form-group mb-2">
                                                    <label for="type" class="form-label fw-bolder ">Duration
                                                    </label>
                                                    <select name="duration" id="duration" class="form-select">
                                                        <option @selected($product->duration == '7') value="7">7 Days
                                                        </option>
                                                        <option @selected($product->duration == '14') value="10">14 Days
                                                        </option>
                                                        <option @selected($product->duration == '21') value="21">21 Days
                                                        </option>
                                                        <option @selected($product->duration == '28') value="28">28 Days
                                                        </option>
                                                        <option @selected($product->duration == '30') value="30">1 Months
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex ">
                                                <h5 class="fs-6 fw-bold me-3">Shipping settings</h5>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <div class="form-group mb-2">
                                                        <label for="rate_table" class="form-label">Enter
                                                            Shipping Partner</label>
                                                        <input type="text" name="shipping_partner"
                                                            id="shipping_partner" class="form-control"
                                                            value="{{ isset($product->rate_table->shipping_partner) ? $product->rate_table->shipping_partner : '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group mb-2">
                                                        <label for="shipping_method"
                                                            class="form-label">Shipping Method</label>
                                                        <select name="shipping_method"
                                                            class="form-select">
                                                            <option @selected(isset($product->rate_table->shipping_method) && $product->rate_table->shipping_method == 'Standard Shipping')
                                                                value="Standard Shipping">Standard
                                                                Shipping</option>
                                                            <option @selected(isset($product->rate_table->shipping_method) && $product->rate_table->shipping_method == 'Express Shipping')
                                                                value="Express Shipping">Express
                                                                Shipping</option>
                                                            <option @selected(isset($product->rate_table->shipping_method) && $product->rate_table->shipping_method == 'Overnight Shipping')
                                                                value="Overnight Shipping">Overnight
                                                                Shipping</option>
                                                            <option @selected(isset($product->rate_table->shipping_method) && $product->rate_table->shipping_method == 'International Shipping')
                                                                value="International Shipping">
                                                                International Shipping</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row justify-content-between">
                                <div class="row">
                                    <div class="col-12">

                                    </div>
                                    <!-- Shipping Table -->
                                    <div class="col-md-8 mb-3">
                                        <h6 class="fs-6 fw-bold py-3 pb-1">Shipping Cost</h6>
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
                                    <!-- RIGHT: VIDEO GUIDE -->
                                    <div class="col-md-4">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <h6 class="fw-bold mb-3">How to set Shipping Cost</h6>

                                                <div class="ratio ratio-16x9">
                                                    <video
                                                        controls
                                                        preload="metadata"
                                                        style="width:100%; border-radius:6px;">
                                                        <source src="{{ asset('uploads/member_packages//How-to-set-Shipping-Cost.mp4') }}" type="video/mp4">
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

                                <div class="d-flex ">
                                    <h5 class="fs-6 fw-bold me-3">Your Settings</h5>
                                </div>

                                <div id="yoursetting">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="htime" class="form-label">Handling Time</label>
                                                <select name="handling_time" class="form-select">
                                                    @php
                                                    $handling_time = isset(
                                                    $product->product_setting->handling_time,
                                                    )
                                                    ? $product->product_setting->handling_time
                                                    : 1;
                                                    @endphp
                                                    @for ($day = 1; $day <= 10; $day++)
                                                        <option @selected($handling_time==$day)
                                                        value="{{ $day }}">
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
                                        <div class="col-md-4 d-none">
                                            <div class="form-group mb-2">
                                                <label for="" class="form-label">State</label>
                                                <select name="state_region" id="state_region"
                                                    class="form-select">
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
                                        <div class="col-md-12 mt-3">
                                            <h6 class="fw-bold fs-6 d-flex">
                                                Accept returns
                                                <div
                                                    class="form-check mx-2 align-items-center form-switch">
                                                    <input class="form-check-input" name="isReturnAccept"
                                                        type="checkbox" role="switch"
                                                        id="isReturnAccept"
                                                        @checked(isset($product->product_setting->isReturnAccept) && $product->product_setting->isReturnAccept == 1) />
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
                                                                    class="form-check-input"
                                                                    @checked(isset($product->product_setting->buyer_pay) && $product->product_setting->buyer_pay) />
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
                                                                    class="form-check-input"
                                                                    @checked(isset($product->product_setting->seller_pay) && $product->product_setting->seller_pay) />
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
                                                                <select class="form-control "
                                                                    name="return_timeline"
                                                                    id="return_timeline">
                                                                    <option @selected(isset($product->product_setting->return_timeline) && $product->product_setting->return_timeline == '7')
                                                                        value="7">7 Days</option>
                                                                    <option @selected(isset($product->product_setting->return_timeline) && $product->product_setting->return_timeline == '14')
                                                                        value="14">14 Days</option>
                                                                    <option @selected(isset($product->product_setting->return_timeline) && $product->product_setting->return_timeline == '21')
                                                                        value="21">21 Days</option>
                                                                    <option @selected(isset($product->product_setting->return_timeline) && $product->product_setting->return_timeline == '28')
                                                                        value="28">28 Days</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 d-flex align-items-center">
                                                            <div class="form-group me-3 w-100">
                                                                <label for="refund">Refund</label>
                                                                <select class="form-control "
                                                                    name="refund" id="refund">
                                                                    <option @selected(isset($product->product_setting->refund) && $product->product_setting->refund == 'Money Back')
                                                                        value="Money Back">Money Back
                                                                    </option>
                                                                    <option @selected(isset($product->product_setting->refund) && $product->product_setting->refund == 'New Item')
                                                                        value="New Item">New Item
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="modalsContainer"></div>
                                <!--main gallery Modal -->
                                <div class="modal fade" id="mainImageUploadModal" tabindex="-1"
                                    aria-labelledby="imageUploadModalLabel" aria-hidden="true"
                                    data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageUploadModalLabel">Edit
                                                    Main
                                                    Gallery Images</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" id="imageGrid">
                                                    @php
                                                    $gallery = json_decode(
                                                    $product->mainGallery,
                                                    true,
                                                    );
                                                    @endphp
                                                    @foreach (range(0, 0) as $index)
                                                    @php
                                                    $image = $gallery[$index]['image'] ?? '';
                                                    $label =
                                                    $index === 0
                                                    ? 'Main Image'
                                                    : 'Image-' . ($index + 1);
                                                    @endphp
                                                    <div class="col-lg-2 col-md-3 col-6 mb-3">
                                                        <span>{{ $label }}</span>
                                                        <label for="mimage-{{ $index }}"
                                                            class="d-block">
                                                            <img id="mpreview-{{ $index }}"
                                                                src="
                                                                                    @if ($image != '') {{ asset('uploads/products/' . $image) }}
                                                                                    @else
                                                                                      https://placehold.co/500 @endif
                                                                                    "
                                                                class="img-thumbnail p-0"
                                                                style="width: 100px; height: 100px;">
                                                        </label>
                                                        <input type="file"
                                                            id="mimage-{{ $index }}"
                                                            class="form-control d-none upload-image2"
                                                            data-index="{{ $index }}"
                                                            accept="image/*">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="alertContainer" class="mt-3">
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-secondary mt-3">
                                            Save Changes
                                        </button>
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
    const mimages = @json($gallery ?? []);

    $(document).ready(function() {
        $(document).on('change', '.upload-image2', function(e) {
            const index = $(this).data('index');
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    mimages[index] = {
                        path: event.target.result
                    };
                    // console.log(mimages);
                    $(`#mpreview-${index}`).attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
<script>
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
    const shippingRateCosts = <?php echo json_encode($product->rate_table->shipping_rate_costs ?? []) ?>;
    populateRows('expeditedTableBody', shippingRateCosts);
    console.log('shippingRateCosts', shippingRateCosts);


    function populateRows(tableId, shippingRateCosts) {
        shippingRateCosts.forEach(cost => {
            addRow(tableId, cost);
        });
    }

    function addRow(tableId, data = null) {

        const index = rowIndex; // ❗ do NOT increment yet

        const isRegion = data?.shipping_type === "region";
        const isCountry = data?.shipping_type === "country";
        const cost = data?.cost ?? "";

        const productCurrencies = <?php echo json_encode([
                                        $product->currency0 ?? 'USD',
                                        $product->currency1 ?? 'USD',
                                        $product->currency2 ?? 'USD'
                                    ]) ?>;

        const currency = productCurrencies[index] || 'USD';

        // ✅ Handle regions correctly
        let selectedRegions = [];
        let isWorldwide = false;

        if (isRegion && Array.isArray(data.shipping_regions)) {
            isWorldwide = data.shipping_regions.some(r => r.isWorldwide == 1);

            if (isWorldwide) {
                selectedRegions = ['worldwide'];
            } else {
                selectedRegions = [...new Set(
                    data.shipping_regions
                    .filter(r => r.region_id)
                    .map(r => String(r.region_id)) // string for select2 safety
                )];
            }
        }

        const selectedCountry =
            isCountry && data?.shipping_regions?.length ?
            data.shipping_regions[0].country_id :
            "";

        const newRow = `
        <tr>
            <td>
                <div class="d-flex">
                    <input type="radio" class="me-2 rate-type"
                        name="rate_type[${index}]"
                        value="region" ${isRegion ? "checked" : ""} />

                    <select class="form-control region-select"
                        name="rate_regions[${index}][]" multiple></select>
                </div>
            </td>

            <td>
                <div class="d-flex">
                    <input type="radio" class="me-2 rate-type"
                        name="rate_type[${index}]"
                        value="country" ${isCountry ? "checked" : ""} />

                    <select class="form-control w-100 country-select"
                        name="rate_country[${index}]">
                        <option value="">Select Country</option>
                    </select>
                </div>
            </td>

            <td>
                <div class="input-group">
                    <select name="currency[${index}]"
                        class="form-select"
                        style="width:5rem">
                        <option value="USD" ${currency === 'USD' ? 'selected' : ''}>USD</option>
                        <option value="EUR" ${currency === 'EUR' ? 'selected' : ''}>EUR</option>
                    </select>

                    <input type="number"
                        class="form-control"
                        name="shipping_cost[${index}]"
                        value="${cost}" step="0.01" min="0">
                </div>
                <small class="text-danger">Set 0 if shipping cost free</small>
            </td>

            <td>
                <button type="button"
                    class="btn btn-danger btn-sm"
                    onclick="removeRow(this)">Delete</button>
            </td>
        </tr>`;

        $('#' + tableId).append(newRow);

        const newRegionSelect = $(`[name="rate_regions[${index}][]"]`);
        const newCountrySelect = $(`[name="rate_country[${index}]"]`);

        initializeRegionSelect(newRegionSelect);
        initializeCountrySelect(newCountrySelect);

        // ✅ Clear old values first
        newRegionSelect.val(null).trigger('change');
        newCountrySelect.val(null).trigger('change');

        if (isRegion) {
            newRegionSelect.val(selectedRegions).trigger('change');
            newCountrySelect.prop('disabled', true);

            if (isWorldwide) {
                disableOtherOptions(newRegionSelect, true);
            }
        }

        if (isCountry) {
            newCountrySelect.val(selectedCountry).trigger('change');
            newRegionSelect.prop('disabled', true);
        }

        rowIndex++; // ✅ increment at END
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
    let imagesArray = [];
    $(document).ready(function() {

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
    let combinations = [];
    const combinationsOld = JSON.parse(<?php echo json_encode($product->variants ?? []); ?>);

    let combinationImages = {};
    $(document).ready(function() {

        const extractVariants = (combinationsOld) => {
            const variantMap = {};
            combinationsOld.forEach(({
                attributes
            }) => {
                Object.entries(attributes).forEach(([key, value]) => {
                    if (!variantMap[key]) {
                        variantMap[key] = new Set();
                    }
                    variantMap[key].add(value);
                });
            });
            return Object.entries(variantMap).map(([name, values], index) => ({
                name,
                values: Array.from(values),
                id: Date.now() + index
            }));
        };

        const variants = extractVariants(combinationsOld);

        // Enable add variant button when input is not empty
        $("#newVariantName").on("input", function() {
            $("#addVariantBtn").prop("disabled", !$(this).val().trim());
        });

        // Add Variant
        $("#addVariantBtn").click(function() {
            const variantName = $("#newVariantName").val().trim();
            if (variantName) {
                const newVariant = {
                    name: variantName,
                    values: [],
                    id: Date.now()
                };
                variants.push(newVariant);
                renderVariants();
                $("#newVariantName").val("");
                $(this).prop("disabled", true);
            }
        });
        renderVariants();
        // Render Variants
        function renderVariants() {
            let html = "";
            variants.forEach((variant, index) => {
                html += `
                <div class="col-md-4 mb-3">
                    <h6 class="text-primary">
                        <span>${variant.name}</span>
                        <i class="fa fa-edit text-primary ms-2 edit-variant" data-index="${index}" style="cursor:pointer;"></i>
                        <i class="fa fa-trash text-danger ms-2 delete-variant" data-index="${index}" style="cursor:pointer;"></i>
                    </h6>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control variant-value-input" placeholder="Enter a value" data-index="${index}">
                        <button class="btn btn-secondary add-value-btn" data-index="${index}" disabled><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="mt-2">
                        ${variant.values.map((value, valIndex) => ` <span class="badge rounded-0 py-2 px-2 bg-primary">
                        ${value} <i class="fa fa-edit text-white edit-value mx-2" data-variant="${index}" data-value="${valIndex}" style="cursor:pointer;"></i>
                        <i class="fa fa-trash text-white delete-value" data-variant="${index}" data-value="${valIndex}" style="cursor:pointer;"></i>
                        </span>`).join(" ")}
                    </div>
                </div>`;
            });
            $("#variantList").html(html);
            attachVariantEvents();

            // Show generate combinations button if there are variants
            $("#generateCombinationsBtn").toggle(variants.length > 0);
        }

        // Attach Events for Variant Actions
        function attachVariantEvents() {
            $(".variant-value-input").on("input", function() {
                const index = $(this).data("index");
                const value = $(this).val().trim();
                $(`.add-value-btn[data-index="${index}"]`).prop("disabled", !value);
            });

            $(".add-value-btn").click(function() {
                const index = $(this).data("index");
                const value = $(`.variant-value-input[data-index="${index}"]`).val().trim();
                if (value) {
                    variants[index].values.push(value);
                    renderVariants();
                }
            });

            $(".edit-variant").click(function() {
                const index = $(this).data("index");
                const newName = prompt("Edit Variant Name", variants[index].name);
                if (newName) {
                    variants[index].name = newName;
                    renderVariants();
                }
            });

            $(".delete-variant").click(function() {
                const index = $(this).data("index");
                variants.splice(index, 1);
                renderVariants();
            });

            $(".edit-value").click(function() {
                const variantIndex = $(this).data("variant");
                const valueIndex = $(this).data("value");
                const newValue = prompt("Edit Value", variants[variantIndex].values[valueIndex]);
                if (newValue) {
                    variants[variantIndex].values[valueIndex] = newValue;
                    renderVariants();
                }
            });

            $(".delete-value").click(function() {
                const variantIndex = $(this).data("variant");
                const valueIndex = $(this).data("value");
                variants[variantIndex].values.splice(valueIndex, 1);
                renderVariants();
            });
        }

        function renderOldCombinations() {
            combinations = combinationsOld.map((comb) => {
                return {
                    ...comb.attributes
                };
            });
            renderCombinations(combinationsOld);
        }
        // Generate Combinations
        $("#generateCombinationsBtn").click(function() {
            // console.log(variants);
            combinations = generateCombinations(variants.map(variant => variant));
            renderCombinations();
        });

        // Generate All Combinations with variant as key
        function generateCombinations(values) {
            if (values.length === 0) return [];
            if (values.length === 1) {
                return values[0].values.map(value => ({
                    [values[0].name]: value
                }));
            }

            const [first, ...rest] = values;
            const restCombinations = generateCombinations(rest);
            return first.values.flatMap(value => restCombinations.map(comb => ({
                ...comb,
                [first.name]: value
            })));
        }

        // Render Combinations
        // Render Combinations Table
        function renderCombinations(oldData = []) {
            let mainGallery = `
                <tr>
                <td></td>
                <td>
                    <button type="button" class="btn btn-sm  btn-primary open-maingallery-btn" data-bs-toggle="modal" data-bs-target="#mainImageUploadModal">
                       <i class="fa-regular fa-image me-3"></i> Main Gallery
                    </button>
                </td>
                <td class="col"></td>
                <td class="col"></td>
                <td></td>
                </tr>`;
            const tableBody = combinations.map((comb, index) => {
                const oldEntry = oldData.find((data) =>
                    JSON.stringify(data.attributes) === JSON.stringify(comb)
                );
                const quantity = oldEntry ? oldEntry.quantity : 1;
                const price = oldEntry ? oldEntry.price : 1;

                const hiddenInputs = Object.entries(comb)
                    .map(
                        ([key, value]) =>
                        `<input type="hidden" name="combinations[${index}][attributes][${key}]" value="${value}">`
                    )
                    .join("");

                return `
            <tr>
                <td class="col" clgstr-index="${index}">${Object.entries(comb)
                    .map(([_, value]) => `${value}`)
                    .join(" - ")}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary open-gallery-btn" data-index="${index}">
                        <i class="fa-regular fa-image me-2"></i> Image Gallery
                    </button>
                    <input type="hidden" name="combinations[${index}][gallery]" />
                </td>
                <td>
                    <input type="number" class="form-control" name="combinations[${index}][quantity]" min="1" value="${quantity}" />
                </td>
                <td>
                    <input type="number" class="form-control" name="combinations[${index}][price]" step="0.01" value="${price}" />
                </td>
                <td>
                    <i class="fa fa-trash text-danger delete-combination-btn" data-index="${index}" style="cursor: pointer;"></i>
                </td>
            </tr>
            ${hiddenInputs}`;
            });

            $("#combinationsBody").html(mainGallery + tableBody.join(""));
            $("#combinationsTable").show();
            attachCombinationEvents();
        }

        // Render Gallery Modals for Each Combination
        // Open Gallery Modal

        function openGalleryModal(index, titleName) {
            const combinationOldData = combinationsOld[index] || {};
            const images = combinationOldData.images || [];
            const baseUrl = "{{ asset('uploads/products/') }}/";
            const imageHandle = Array.from({
                length: 12
            }, (_, i) => {

                var gImage = baseUrl + images[i];
                const image = images[i];
                const isBase64 = image && image.startsWith("data:image"); // Check if it's Base64
                const imageSrc = image ?
                    isBase64 ?
                    image // Use Base64 directly
                    :
                    `${gImage}` // Use filename path
                    :
                    "https://placehold.co/500"; // Placeholder if no image

                var imageTag =
                    `<img id="preview-${i}" src="${imageSrc}" class="img-thumbnail p-0 mt-2" style="width: 100px; height: 100px;">`;
                return `
                        <div class="col-lg-2 col-md-3 col-6 mb-3">
                          <span>Image-${i+1}</span>
                          <label for="image-${i}" class="d-block" style="cursor:pointer;">
                            ${imageTag}
                          </label>
                          <input type="file" id="image-${i}" class="form-control d-none upload-image" data-index="${index}" data-slot="${i}" accept="image/*">
                        </div>
                      `
            }).join("");
            const modalHtml = `
            <div class="modal fade" id="galleryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Gallery for ${titleName}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row" id="gallery-images-container">
                               
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary save-gallery-btn" data-index="${index}">Save</button>
                        </div>
                    </div>
                </div>
            </div>`;

            $("#modalsContainer").html(modalHtml); // Inject modal into the DOM
            $("#gallery-images-container").html(imageHandle);
            $("#galleryModal").modal("show"); // Show the modal
        }

        // Attach Combination Events
        function attachCombinationEvents() {
            $(".open-gallery-btn").click(function() {
                const index = $(this).data("index");
                const titleName = $(this).closest("tr").find("td").first().text();
                openGalleryModal(index, titleName);
            });

            $(".delete-combination-btn").click(function() {
                const index = $(this).data("index");
                combinations.splice(index, 1);
                delete combinationImages[index]; // Clear images for deleted combination
                renderCombinations();
            });
        }

        // Handle Image Upload and Preview
        $(document).on("change", ".upload-image", function() {
            // alert('ggg')
            const index = $(this).data("index");
            const slot = $(this).data("slot");
            const file = this.files[0];
            // console.log(file);
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(`#preview-${slot}`).attr("src", e.target.result);

                    if (!combinationsOld[index]) {
                        combinationsOld[index] = {};
                    }
                    combinationsOld[index].images[slot] = e.target.result;;
                };
                reader.readAsDataURL(file);
            }
        });

        // Save Gallery Data
        $(document).on("click", ".save-gallery-btn", function() {
            $(`#galleryModal`).modal("hide");
        });
        renderOldCombinations();
    });
</script>
<script>
    $(document).ready(function() {
        function base64ToFile(base64String, fileName) {
            const mimeType = base64String.split(';')[0].split(':')[1];
            const byteCharacters = atob(base64String.split(',')[1]);
            const byteArrays = [];

            for (let offset = 0; offset < byteCharacters.length; offset += 1024) {
                const slice = byteCharacters.slice(offset, offset + 1024);
                const byteNumbers = new Array(slice.length);

                for (let i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                byteArrays.push(new Uint8Array(byteNumbers));
            }
            const fileBlob = new Blob(byteArrays, {
                type: mimeType
            });
            return new File([fileBlob], fileName, {
                type: mimeType
            });
        }
        $('#edit_product_form').on('submit', function(e) {
            e.preventDefault();

            $('#loadingOverlay').show();
            $(this).find(':submit').prop('disabled', true);

            // Clear any existing alerts
            $('#alertContainer').html('');

            var formData = new FormData(this);

            combinations.forEach(function(combination, index) {
                if (
                    !combinationsOld ||
                    !combinationsOld[index] ||
                    !Array.isArray(combinationsOld[index].images)
                ) {
                    return;
                }

                const images = combinationsOld[index].images;

                for (let i = 0; i < images.length; i++) {

                    if (images[i] && images[i].startsWith('data:image')) {

                        const ext = images[i].split(';')[0].split('/')[1];
                        const file = base64ToFile(images[i], `image${i}.${ext}`);

                        formData.append(`combinations[${index}][gallery][${i}]`, file);
                    } else {
                        formData.append(
                            `combinations[${index}][gallery][${i}]`,
                            images[i] || null
                        );
                    }
                }
            });

            mimages.forEach((image, index) => {

                const inputEl = document.getElementById(`mimage-${index}`);

                // If input does not exist, skip safely
                if (!inputEl || !inputEl.files) {
                    return;
                }

                const file = inputEl.files[0];

                if (file) {
                    formData.append(`main_gallery_images[${index}]`, file);
                } else if (image && image.image) {
                    formData.append(`existing_images[${index}]`, image.image);
                }
            });

            $.ajax({
                url: '{{ route("seller.update.product.multiply") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        // Show success message and reload page
                        toastr.success('Successfully update your product');
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
                    $('#edit_product_form').find(':submit').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection