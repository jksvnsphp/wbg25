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
                <h6 class="fs-5 text-light py-3 px-3">Edit Product</h6>

                <div class="card shadow rounded-0">


                    <form class="card-body" id="edit_product_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="col-md-9">
                                <h6 class="fw-bold text-primary fs-5">
                                    Start your listing and make Money selling on World Business
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
                            @livewire('category-suggestion', [
                                'searchTerm' => $product->searched_cat,
                                'hasPath' => $product->searched_path,
                                'parentCategoryId' => $product->parent_category_id,
                                'categoryId' => $product->category_id,
                                'childCategoryId' => $product->subcategory_id,
                                'endChildCategoryId' => $product->childcategory_id,
                                'old_attributes_data' => $oldAttributes,
                                'buyerNeedDetail' => $product->isAttribute == 1 ? true : false,
                                'specificDetails' => $extraAttributes,
                                'itemCondition' => $product->item_condition,
                            ])
                            <div class="col-md-9 mt-4">
                                <h6 class="text-uppercase fw-bold fs-6">
                                    Enter Color, Size and No. of pieces
                                </h6>
                                <div id="itemRows">
                                    @if (isset($product->attr_data) && json_decode($product->attr_data) != null)
                                        @php
                                            $indexCount = 0;
                                            $attrData = json_decode($product->attr_data);
                                            $indexCount = isset($attrData) ? count($attrData) : 0;
                                        @endphp
                                        @foreach ($attrData as $attr)
                                            <div class="row align-items-center justify-content-start mb-3">
                                                <div class="col-auto">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="data_atr[{{ $attr->id - 1 }}]" checked />
                                                </div>

                                                <div class="col">
                                                    <input type="text" class="form-control" placeholder="Color"
                                                        name="color_atr[{{ $attr->id - 1 }}]" value="{{ $attr->color }}">
                                                </div>
                                                -
                                                <div class="col">
                                                    <input type="text" class="form-control" placeholder="Size"
                                                        name="size_atr[{{ $attr->id - 1 }}]" value="{{ $attr->size }}">
                                                </div>
                                                -
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Quantity"
                                                        name="quantity_atr[{{ $attr->id - 1 }}]"
                                                        value="{{ $attr->qty }}">
                                                </div>
                                                <div class="col-auto">
                                                    <a href="javaScript:void(0)" class="text-danger remove-row">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="row align-items-center justify-content-start mb-3">
                                        <div class="col-auto">
                                            <input type="checkbox" class="form-check-input"
                                                name="data_atr[{{ $indexCount }}]" />
                                        </div>

                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Color"
                                                name="color_atr[{{ $indexCount }}]">
                                        </div>
                                        -
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Size"
                                                name="size_atr[{{ $indexCount }}]">
                                        </div>
                                        -
                                        <div class="col">
                                            <input type="number" class="form-control" placeholder="Quantity"
                                                name="quantity_atr[{{ $indexCount }}]">
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
                                                <div class="row mt-2">
                                                    <h6 class="fw-bold text-uppercase ">Gallery Images</h6>
                                                    <div class="col-12 d-flex flex-wrap ">
                                                        @if (isset($product->gallery[0]))
                                                            @foreach ($product->gallery as $gimage)
                                                                <div class="preview-img"
                                                                    data-image-id="{{ $gimage->id }}"
                                                                    style="width: 100px; height: 100px; position: relative; margin: 5px;">
                                                                    <img src="{{ asset('uploads/products/gallery/' . $gimage->image) }}"
                                                                        alt="image preview"
                                                                        style="width: 100%; height: 100%; object-fit: cover;" />
                                                                    <span class="delete-gimage"
                                                                        style="position: absolute; top: -7%; right: -7%; cursor: pointer; color: red;">
                                                                        <i class="fa-solid fa-trash "></i>
                                                                    </span>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="imagePreview" class="d-flex flex-wrap mt-2">

                                                </div>
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
                                                <div
                                                    class="form-group mt-2 d-flex align-items-center flex-sm-nowrap flex-wrap">
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
                                            <div class="col-md-7">
                                                <h6 class="text-uppercase fw-bold ">Set Pricing</h6>
                                                <div class="form-check mb-3 d-flex px-0">
                                                    <input type="checkbox" class="me-2" name="ispcs[]"
                                                        @checked($product->isPrice0) />
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" name="pcsmin[0]"
                                                            class="form-control pcs-input" placeholder="Min Qty"
                                                            value="{{ $product->qtymin0 }}" />
                                                        -
                                                        <input type="number" name="pcsmax[0]"
                                                            class="form-control pcs-input me-2" placeholder="Max Qty"
                                                            value="{{ $product->qtymax0 }}" />
                                                    </div>
                                                    <div class="input-group">
                                                        <select name="currency[]"
                                                            style="width: 5rem !important;flex:unset;"
                                                            class="form-select input-group-addon">
                                                            <option @selected($product->currency0 == 'USD') value="USD">USD
                                                            </option>
                                                            <option @selected($product->currency0 == 'EUR') value="EUR">EUR
                                                            </option>
                                                        </select>
                                                        <input type="number" step="0.01" name="cost[]"
                                                            class="form-control" placeholder="0.00"
                                                            value="{{ $product->price0 }}" />
                                                    </div>
                                                </div>
                                                <div class="form-check mb-3 d-flex px-0">
                                                    <input type="checkbox" class="me-2" name="ispcs[]"
                                                        @checked($product->isPrice1) />
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" name="pcsmin[1]"
                                                            class="form-control pcs-input" placeholder="Min Qty"
                                                            value="{{ $product->qtymin1 }}" />
                                                        -
                                                        <input type="number" name="pcsmax[1]"
                                                            class="form-control pcs-input me-2" placeholder="Max Qty"
                                                            value="{{ $product->qtymax1 }}" />
                                                    </div>
                                                    <div class="input-group">
                                                        <select name="currency[]"
                                                            style="width: 5rem !important;flex:unset;"
                                                            class="form-select input-group-addon">
                                                            <option @selected($product->currency1 == 'USD') value="USD">USD
                                                            </option>
                                                            <option @selected($product->currency1 == 'EUR') value="EUR">EUR
                                                            </option>
                                                        </select>
                                                        <input type="number" step="0.01" name="cost[]"
                                                            class="form-control" placeholder="0.00"
                                                            value="{{ $product->price1 }}" />
                                                    </div>
                                                </div>
                                                <div class="form-check  d-flex px-0">
                                                    <input type="checkbox" class="me-2" name="ispcs[]"
                                                        @checked($product->isPrice2) />
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" name="pcsmin[2]"
                                                            class="form-control pcs-input" placeholder="Min Qty"
                                                            value="{{ $product->qtymin2 }}" />
                                                        -
                                                        <input type="number" name="pcsmax[2]"
                                                            class="form-control pcs-input me-2" placeholder="Max Qty"
                                                            value="{{ $product->qtymax2 }}" />
                                                    </div>
                                                    <div class="input-group">
                                                        <select name="currency[]"
                                                            style="width: 5rem !important;flex:unset;"
                                                            class="form-select input-group-addon">
                                                            <option @selected($product->currency2 == 'USD') value="USD">USD
                                                            </option>
                                                            <option @selected($product->currency2 == 'EUR') value="EUR">EUR
                                                            </option>
                                                        </select>
                                                        <input type="number" step="0.01" name="cost[]"
                                                            class="form-control" placeholder="0.00"
                                                            value="{{ $product->price2 }}" />
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
                                                <div class="col-md-7 mt-3">
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
                                                                    @php
                                                                        $handling_time = isset(
                                                                            $product->product_setting->handling_time,
                                                                        )
                                                                            ? $product->product_setting->handling_time
                                                                            : 1;
                                                                    @endphp
                                                                    @for ($day = 1; $day <= 10; $day++)
                                                                        <option @selected($handling_time == $day)
                                                                            value="{{ $day }}">
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
                                                                    class="form-select select-prevent">
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
                                                                    class="form-select select-prevent">
                                                                    <option value="">Select...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group mb-3">
                                                                <label for="" class="form-label">City</label>
                                                                <input type="text" list="cities" name="city"
                                                                    id="city" class="form-control" readonly
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
                                                                    readonly
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
                                                                                <select class="form-select"
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
                                                                                <select class="form-select"
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
                                                <div id="alertContainer" class="mt-3">

                                                </div>
                                                <button type="submit" class="btn btn-secondary mt-3">
                                                    Save Changes
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
        const shippingRateCosts = @json($product->rate_table->shipping_rate_costs);
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
                isWorldwide ?
                ['worldwide'] :
                data.shipping_regions.map(region => region.region_id) :
                [];
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
        <td><input type="number" class="form-control" placeholder="Enter Cost" name="shipping_cost[${index}]" value="${cost}"></td>
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
        // $('#country_region').select2({
        //     width: "100%",
        //     placeholder: "Select Country",
        // });
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
            $('#edit_product_form').on('submit', function(e) {
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
                    url: '{{ route('seller.update.product') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            // Show success message and reload page
                            alert('Successfully update your product');
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
                        $('#edit_product_form').find(':submit').prop('disabled', false);
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

    <script>
        $(document).on('click', '.delete-gimage', function() {
            const imageId = $(this).closest('.preview-img').data('image-id');
            const parentDiv = $(this).closest('.preview-img');

            if (confirm('Are you sure you want to delete this image?')) {
                var gimage_url = "{{ route('seller.delete.product.image') }}/" + imageId;
                $.ajax({
                    url: gimage_url,
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            parentDiv.remove();
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while deleting the image.');
                    }
                });
            }
        });
        $(document).ready(function () {
                function preventSelect() {
                  $('.select-prevent').on('mousedown focus', function (e) {
                     e.preventDefault(); 
                  });
                }
                preventSelect();
         });
    </script>
@endsection
