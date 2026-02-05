@extends('external-user.external-frame')
@section('meta_data')
<title>{{ $metaTitle ?? ($product->name ?? '') }}</title>
<meta name="description" content="{{ $metaDescription ?? '' }}">
<meta name="keywords" content="{{ $metaKeywords ?? '' }}">
@endsection
@section('external-main-content')
<style>
    .custome_table td {
        align-content: center;
    }

    .in-img-wrapper {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        max-width: 100%;
        -ms-overflow-style: none;
        /* Hide scrollbar for Internet Explorer and Edge */
        scrollbar-width: none;
        /* Hide scrollbar for Firefox */
    }

    .in-img-wrapper::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar for Chrome, Safari, and Opera */
    }

    .in-img {
        flex: 0 0 auto;
        margin-right: 10px;
        border-radius: 5px;
        scroll-snap-align: center;
    }

    .in-img img {
        width: 100px;
        height: auto;
        object-fit: cover;
        border-radius: 5px;
    }
</style>
<section class="container-fluid">
    <p class="mb-0 pb-0 mt-3"><a class="text-primary" title="Home" href="{{ url('/') }}">Home</a> > <a class="text-primary" title="Products" href="{{ url('/products') }}">Products</a> {!! $product->searched_path !!}</p>
    <div class="row">
        <div class="col-xl-9 mt-4">
            <div class="card rounded-0 border-0">
                <div class="row">
                    <div class="col-md-6" style="border: 1px solid #ddd">
                        @if ($product->isMultiple == 0)
                        <div class="card border-0 rounded-0">
                            <div class="card-body img_view">
                                <img class="large-view"
                                    src="@if (isset($product->gallery[0]->image) && $product->gallery[0]->image != '') {{ asset('uploads/products/gallery/' . $product->gallery[0]->image) }} @else https://placehold.co/400 @endif" class="img-fluid" alt="product image" />
                            </div>
                            <hr />
                            <div class="card-footer border-0 d-flex bg-white">
                                @if (isset($product->gallery[0]->image) && $product->gallery[0]->image != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/products/gallery/' . $product->gallery[0]->image) }}"
                                        alt="product image" />
                                </div>
                                @endif
                                @if (isset($product->gallery[1]->image) && $product->gallery[1]->image != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/products/gallery/' . $product->gallery[1]->image) }}"
                                        alt="product image" />
                                </div>
                                @endif
                                @if (isset($product->gallery[2]->image) && $product->gallery[2]->image != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/products/gallery/' . $product->gallery[2]->image) }}"
                                        alt="product image" />
                                </div>
                                @endif
                                @if (isset($product->gallery[3]->image) && $product->gallery[3]->image != '')
                                <div class="in-img">
                                    <img class="small-view"
                                        src="{{ asset('uploads/products/gallery/' . $product->gallery[3]->image) }}"
                                        alt="product image" />
                                </div>
                                @endif

                            </div>
                        </div>
                        @else
                        <div class="card border-0 rounded-0">
                            <div class="card-body img_view">
                                <img class="large-view" id="largeView" src="https://placehold.co/400"
                                    class="img-fluid" alt="product image" />
                            </div>
                            <hr />
                            <div
                                class="card-footer border-0 d-flex bg-white small-gallery align-items-center w-100">
                                <a id="prevBtn" class="text-primary" href="javaScript:void(0)">
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                                <div class="in-img-wrapper w-100 d-flex overflow-x-auto overflow-y-hidden "
                                    style="scroll-snap-type: x mandatory;" id="smallGallery">

                                </div>
                                <a href="javaScript:void(0)" class="text-primary" id="nextBtn">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6 product_details_single" style="border: 1px solid #ddd">
                        <h1 class="text-center product_title fs-5 fw-bolder mt-3">
                            {{ $product->name }}
                        </h1>
                        <p class="text-center fw-bold">
                            {{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $product->item_condition) }}
                        </p>
                        <p class="text-center heading mx-2 mb-4 mt-2 fs-6 d-block">
                            Ready to ship
                        </p>

                        <!-- price stage -->
                        @if ($product->isMultiple == 0)
                        <div class="row mt-4 justify-content-center">
                            @if (isset($product->isPrice0) && $product->isPrice0 == 1)
                            <div class="col-md-4 mt-2 d-flex flex-column justify-content-center">
                                <span
                                    class="py-1 text-center d-inline">{{ $product->qtymin0 }}-{{ $product->qtymax0 }}
                                    Pieces</span>
                                <h3 class="mt-3 fw-bold text-center text-secondary fs-4">
                                    {{ $product->currency0 == 'USD' ? "US$" : 'EU€' }}{{ $product->price0 }}
                                </h3>
                            </div>
                            @endif
                            @if (isset($product->isPrice1) && $product->isPrice1 == 1)
                            <div class="col-md-4 mt-2 d-flex flex-column justify-content-center">
                                <span
                                    class="py-1 text-center d-inline">{{ $product->qtymin1 }}-{{ $product->qtymax1 }}
                                    Pieces</span>
                                <h3 class="mt-3 fw-bold text-center  fs-4">
                                    {{ $product->currency1 == 'USD' ? "US$" : 'EU€' }}{{ $product->price1 }}
                                </h3>
                            </div>
                            @endif
                            @if (isset($product->isPrice2) && $product->isPrice2 == 1)
                            <div class="col-md-4 mt-2 d-flex flex-column justify-content-center">
                                <span
                                    class="py-1 text-center d-inline">{{ $product->qtymin2 }}-{{ $product->qtymax2 }}
                                    Pieces</span>
                                <h3 class="mt-3 fw-bold text-center  fs-4">
                                    {{ $product->currency2 == 'USD' ? "US$" : 'EU€' }}{{ $product->price2 }}
                                </h3>
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="row justify-content-center">
                            <div class="col-md-4  d-flex flex-column justify-content-center">

                                <h3 class="fw-bolder text-center text-secondary  fs-4" id="priceMultiply">
                                    US$ 100.00
                                </h3>
                                <input type="hidden" name="price" id="priceVariant" value="100.00">
                            </div>
                        </div>
                        @endif

                        <hr class="mt-3" style=" border: #ddd; height: 5px !important; background-color: #ddd; " />
                        <div class="row justify-content-center">
                            <div class="col-md-11">
                                @if ($product->isMultiple == 1)
                                @php

                                $variants = is_string($product->variants)
                                ? json_decode($product->variants, true)
                                : $product->variants;

                                if (!$variants || !is_array($variants)) {
                                $variants = [];
                                }

                                $attributes = [];
                                foreach ($variants as $variant) {
                                if (isset($variant['attributes'])) {
                                foreach ($variant['attributes'] as $key => $value) {
                                $attributes[$key][] = $value;
                                }
                                }
                                }

                                foreach ($attributes as $key => &$values) {
                                $values = array_unique($values);
                                }
                                unset($values);
                                $defaultSelection = [];
                                foreach ($attributes as $key => $values) {
                                $defaultSelection[$key] = $values[0];
                                }
                                @endphp

                                <!-- Render the Select Fields Dynamically -->
                                @if (!empty($attributes))
                                @foreach ($attributes as $key => $values)
                                <div>

                                    <select class="form-select attribute-select mb-2"
                                        data-attribute="{{ $key }}" id="{{ $key }}"
                                        name="{{ $key }}">
                                        <option value="">Select {{ $key }}</option>
                                        @foreach ($values as $value)
                                        <option
                                            {{ isset($defaultSelection[$key]) && $defaultSelection[$key] == $value ? 'selected' : '' }}
                                            value="{{ $value }}">{{ $value }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endforeach
                                @else
                                <p>No Combination available.</p>
                                @endif

                                @endif
                            </div>
                            <div class="col-12"></div>
                            <div class="col-md-8 text-center">
                                <div class="quantity">
                                    Quantity :
                                    <input type="number" name="qty" id="qty"
                                        style=" height: 37px; width: 50px !important; outline: none !important; border: 1px solid #bbb9b9;border-radius: 3px !important;"
                                        value="1" step="1" min="1" max="{{ $product->totalQty }}" />
                                    @if ($product->isMultiple == 0)
                                    <small style="font-size: 14px" class="text-muted my-2">
                                        <span>
                                            {{ $product->totalQty }}
                                        </span>
                                        available/
                                        <span class="text-danger">{{ $product->soldQty }} Sold</span></small>
                                    @else
                                    <small style="font-size: 14px" class="text-muted my-2">
                                        <span id="avQty">
                                            0
                                        </span>
                                        available/
                                        <span class="text-danger" id="avsoldQty">0 Sold</span></small>
                                    @endif
                                </div>
                            </div>

                            <?php
                            //echo '<pre>';
                            //echo print_r($product);
                            //echo '</pre>';

                            ?>

                            @if ($product->isMultiple == 0)
                            <p class="text-center mt-2 mb-0 text-primary" style="font-size:13px;" id="ends_in11" data-end="{{ $product->created_at }}">
                                {{ $product->remaining_time  }}
                            </p>
                            @endif
                            <div class="my-4 mt-2 d-flex justify-content-center" id="btn-group-action">
                                <a href="javascript:void(0)" class="btn btn-primary me-3 checkout-now"
                                    data-id="{{ $product->id }}">Buy Now</a>
                                <a href="javascript:void(0)" class="btn btn-secondary add-to-cart"
                                    data-id="{{ $product->id }}">Add To Cart </a>
                            </div>
                            <p class="text-danger d-block mt-3 text-center d-none" id="unavailableQty">Currently
                                unavailable</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 my-4 rounded-0">
                <nav class="tab_card_header">
                    <div class="nav border-0 nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-product-details-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-product-details" type="button" role="tab"
                            aria-controls="nav-product-details" aria-selected="true" onclick="productDetail()">
                            Product Details
                        </button>
                        <button class="nav-link" id="nav-image-video-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-image-video" type="button" role="tab"
                            aria-controls="nav-image-video" aria-selected="false" onclick="imageVideo()">
                            Image & Videos
                        </button>
                        <button class="nav-link" id="nav-shipping-pay-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-shipping-pay" type="button" role="tab"
                            aria-controls="nav-shipping-pay" aria-selected="false" onclick="toggleShipmentInfo()">
                            Shippings, Returns & Payments
                        </button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade pt-5 show active" id="nav-product-details" role="tabpanel"
                        aria-labelledby="nav-product-details-tab">
                        <div class="d-flex mb-4 justify-content-between">
                            <p>Seller assumes all responsibility for this listing.</p>
                            <h5>
                                <strong class="fw-bolder me-2">WBG24</strong>
                                <span class="text-muted">Item Number :
                                    @php
                                    $formattedId = str_pad($product->id, 9, '0', STR_PAD_LEFT);
                                    echo $formattedId;
                                    @endphp
                                </span>
                            </h5>
                        </div>
                        @if ($product->isAttribute == 1)
                        <div class="row">
                            <h4 class=" fw-bold fs-4">Item Specifics</h4>
                            <div class="col-md-12 mt-3">
                                <div class="row">

                                    <div class="col-md-6 mb-2">
                                        <div class="responsive-table">

                                            <table class="table custome_table table-bordered">

                                                <tbody>
                                                    @foreach ($product->product_attributes->slice(0, ceil($product->product_attributes->count() / 2)) as $attribute)
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-bold">
                                                                {{ isset($attribute->categoryAttribute->attribute->name) ? $attribute->categoryAttribute->attribute->name : 'N/A' }}
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            {{ isset($attribute->attribute_value) ? $attribute->attribute_value : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Second Table -->
                                    <div class="col-md-6 mb-2">
                                        <div class="responsive-table">
                                            <table class="table custome_table table-bordered">

                                                <tbody>
                                                    @foreach ($product->product_attributes->slice(ceil($product->product_attributes->count() / 2)) as $attribute)
                                                    <tr>
                                                        <td>
                                                            <h6 class="fw-bold">
                                                                {{ isset($attribute->categoryAttribute->attribute->name) ? $attribute->categoryAttribute->attribute->name : 'N/A' }}
                                                            </h6>
                                                        </td>
                                                        <td>
                                                            {{ isset($attribute->attribute_value) ? $attribute->attribute_value : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if (!empty($product->extraAttributes))
                                    @php
                                    $extraAttributes = json_decode($product->extraAttributes, true);
                                    // dd($extraAttributes);
                                    @endphp
                                    @foreach (array_chunk($extraAttributes, 2) as $extraAttribute)
                                    <div class="col-md-6 ">
                                        <table class="table custome_table table-bordered">
                                            <tbody>
                                                @foreach ($extraAttribute as $extraAttr)
                                                @if (isset($extraAttr['name']) && $extraAttr['name'] != '')
                                                <tr>
                                                    <td class="fw-bold">
                                                        {{ $extraAttr['name'] ?? 'N/A' }}
                                                    </td>
                                                    <td>{{ $extraAttr['value'] ?? 'N/A' }}</td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane fade pt-5" id="nav-image-video" role="tabpanel"
                        aria-labelledby="nav-image-video-tab">
                        <h6 class="fw-bold">Images</h6>
                        <div class="row" id="gl-images">
                            @if (isset($product->gallery[0]->image) && $product->gallery[0]->image != '')
                            <div class="col-md-2 mt-2">
                                <img class="small-view h-100 w-100"
                                    src="{{ asset('uploads/products/gallery/' . $product->gallery[0]->image) }}"
                                    alt="" />
                            </div>
                            @endif
                            @if (isset($product->gallery[1]->image) && $product->gallery[1]->image != '')
                            <div class="col-md-2 mt-2">
                                <img class="small-view h-100 w-100"
                                    src="{{ asset('uploads/products/gallery/' . $product->gallery[1]->image) }}"
                                    alt="" />
                            </div>
                            @endif
                            @if (isset($product->gallery[2]->image) && $product->gallery[2]->image != '')
                            <div class="col-md-2 mt-2">
                                <img class="small-view h-100 w-100"
                                    src="{{ asset('uploads/products/gallery/' . $product->gallery[2]->image) }}"
                                    alt="" />
                            </div>
                            @endif
                            @if (isset($product->gallery[3]->image) && $product->gallery[3]->image != '')
                            <div class="col-md-2 mt-2">
                                <img class="small-view h-100 w-100"
                                    src="{{ asset('uploads/products/gallery/' . $product->gallery[3]->image) }}"
                                    alt="" />
                            </div>
                            @endif
                        </div>
                        <hr />
                        <h6 class="fw-bold">Videos</h6>
                        <div class="row" id="gl-video">
                            <div class="col-md-3">
                                @if(isset($product->video->video_url) && $product->video->video_url!=null)
                                <div class="mt-3 mx-auto" style="height: 9rem; ">
                                    <video id="my-video" class="video-js vjs-default-skin" controls preload="auto"
                                        style="height: 100%; width:100%">
                                        <source
                                            src="{{ asset('uploads/products/videos/' . $product->video->video_url) }}"
                                            type="video/mp4" />
                                        <p class="vjs-no-js">To view this video please enable JavaScript, and consider
                                            upgrading to a web browser that supports HTML5 video</p>
                                    </video>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @php
                    $data = isset($product->shippingData[0]) ? $product->shippingData[0] : [];

                    @endphp
                    <div class="tab-pane fade pt-5" id="nav-shipping-pay" role="tabpanel"
                        aria-labelledby="nav-shipping-pay-tab">
                        <div class="row">
                            <div class="col-12 mt-2">
                                <h6 class="fw-bolder my-2">Shipping and handling</h6>
                                <p>
                                    Item location:
                                    <strong
                                        class="fw-bold">{{ isset($product->item_country->name) ? $product->item_country->name : '' }}
                                    </strong>
                                </p>

                                <p class="mt-3">Ships to:
                                    <strong class="fw-bold">
                                        @if (isset($data['is_worldwide']))
                                        {{ $data['is_worldwide']['status'] }}
                                        @else
                                        @php
                                        $regionNames = collect($data['regions'] ?? [])->pluck('name')->filter()->values()->all();
                                        $countryNames = collect($data['countries'] ?? [])->pluck('name')->filter()->values()->all();

                                        $shipsToParts = array_values(array_filter([
                                        implode(', ', $regionNames),
                                        implode(', ', $countryNames),
                                        ], fn($value) => $value !== ''));

                                        $shipsTo = implode(', ', $shipsToParts);
                                        @endphp

                                        {{ $shipsTo !== '' ? $shipsTo : 'N/A' }}
                                        @endif
                                    </strong>
                                </p>
                                <div class="row mt-4">
                                    <div class="col-md-12 mt-4">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="table-active">
                                                        <th>Shipping cost</th>
                                                        <th>Shipping Partner</th>
                                                        <th>Shipping Method</th>
                                                        <th>Handling Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p class="fontp">
                                                                <strong class="fw-bolder">

                                                                    @if(isset($yourShippingCost['shipping_cost']))

                                                                    {{-- FREE SHIPPING --}}
                                                                    @if($yourShippingCost['shipping_cost'] == 0)
                                                                    Free International Shipping

                                                                    {{-- PAID SHIPPING --}}
                                                                    @else

                                                                    {{-- COUNTRY LEVEL --}}
                                                                    @if(!empty($data['countries']) && count($data['countries']) > 0)

                                                                    <div style="color:#FF7519;">Cost by Country:</div>
                                                                    <div class="shipping-list" id="country-list">

                                                                        @foreach($data['countries'] as $index => $country)
                                                                        @php $currencyVar = "currency".$index; @endphp

                                                                        <div class="shipping-item">
                                                                            {{ $country['name'] }} :
                                                                            {{ $product->$currencyVar ?? 'USD' }}$
                                                                            {{ number_format($country['cost'], 2) }}
                                                                        </div>
                                                                        @endforeach
                                                                    </div>

                                                                    {{-- REGION LEVEL --}}
                                                                    @elseif(!empty($data['regions']) && count($data['regions']) > 0)

                                                                    <div style="color:#FF7519;">Cost by Region:</div>
                                                                    <div class="shipping-list" id="region-list">

                                                                        @foreach($data['regions'] as $index => $region)
                                                                        <div class="shipping-item">
                                                                            <strong>{{ $region['name'] }}</strong> :
                                                                            USD${{ number_format($region['cost'], 2) }}
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                    @else
                                                                    No Shipping Zone
                                                                    @endif
                                                                    @endif
                                                                    @endif
                                                                </strong>
                                                            </p>
                                                        </td>
                                                        <td>{{ isset($data['shipping_partner']) ? $data['shipping_partner'] : 'N/A' }}</td>
                                                        <td>{{ isset($data['shipping_method']) ? $data['shipping_method'] : 'N/A' }}</td>
                                                        <td>{{ $product->duration }} Business Days</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <h4 class="my-2 mb-4 fw-bold fs-4">Return policy</h4>
                                        <div class="table-responsive">
                                            @if (isset($product->product_setting->seller_pay) &&
                                            $product->product_setting->seller_pay == 1 &&
                                            $product->product_setting->isReturnAccept == 1)
                                            <table class="table">
                                                <thead>
                                                    <tr class="table-active">
                                                        <th>Seller accept return within</th>
                                                        <th>Refund will be given as</th>
                                                        <th>Return shipping</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $product->product_setting->return_timeline }} Days
                                                        </td>
                                                        <td>Money Back</td>
                                                        <td>Seller pays for return shipping</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @else
                                            <table class="table">
                                                <thead>
                                                    <tr class="table-active">
                                                        <th>Seller don't accept return</th>
                                                    </tr>
                                                </thead>

                                            </table>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <h4 class="my-2 fw-bold fs-4">Payment Details</h4>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="table-active">
                                                        <th>Payment methods</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex flex-wrap">
                                                                @if (isset($product->paymentInfo->isPayPal) && $product->paymentInfo->isPayPal == 1)
                                                                <div style="height: 45px; width: 70px; border: 1px solid black;"
                                                                    class="rounded-2 me-2">
                                                                    <img src="{{ asset('world-business/images/icons/1156727_finance_payment_paypal_icon.png') }}"
                                                                        class="h-100 w-100"
                                                                        style="object-fit: contain; object-position: center;"
                                                                        alt="" />
                                                                </div>
                                                                @endif
                                                                @if (isset($product->paymentInfo->isGooglePay) && $product->paymentInfo->isGooglePay == 1)
                                                                <div
                                                                    style="height: 45px; width: 70px; border: 1px solid black; " class="rounded-2 me-2">
                                                                    <img src="{{ asset('world-business/images/icons/1156750_finance_mastercard_payment_icon.png') }}"
                                                                        class="h-100 w-100"
                                                                        style=" object-fit: contain; object-position: center; "
                                                                        alt="" />
                                                                </div>
                                                                @endif
                                                                @if (isset($product->paymentInfo->isBankDetail) && $product->paymentInfo->isBankDetail == 1)
                                                                <div style=" height: 45px; width: 70px; border: 1px solid black; "
                                                                    class="rounded-2 me-2">
                                                                    <img src="{{ asset('uploads/logo/bank.png') }}"
                                                                        class="h-100 w-100"
                                                                        style=" object-fit: contain;  object-position: center; "
                                                                        alt="" />
                                                                </div>
                                                                @endif
                                                                @if (isset($product->paymentInfo->isOther) && $product->paymentInfo->isOther == 1)
                                                                <div style=" height: 45px; width: 70px; border: 1px solid black; "
                                                                    class="rounded-2 me-2">
                                                                    <img src="{{ asset('apple-pay.png') }}"
                                                                        class="h-100 w-100"
                                                                        style=" object-fit: contain;  object-position: center; "
                                                                        alt="" />
                                                                </div>
                                                                @endif

                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="card border-0 rounded-0">
                <div class="row">
                    <h5 class="fs-5 fw-bold py-3">Product Description</h5>
                    <hr />
                    <div class="col-md-12 my-4">
                        {!! html_entity_decode($product->description) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 my-4">
            <div class="card rounded-0">
                <div class="card-header rounded-0 d-flex justify-content-between">
                    <h5 class="fw-bold">
                        {{ isset($product->vendor->company->name) ? $product->vendor->company->name : '' }}
                    </h5>
                    <div>
                        <div class="d-flex justify-content-center">
                            @php
                            $rating = $product->average_rating ?? 0;
                            $fullStars = floor($rating);
                            $emptyStars = 5 - $fullStars;
                            @endphp

                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star text-secondary"></i>
                                @endfor
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="fas fa-star " style="color:gray;"></i>
                                    @endfor
                        </div>
                    </div>
                </div>
                <div class="card-body p-1">
                    <div class="d-flex justify-content-between">
                        <p class="px-0 mx-0 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('world-business/images/badge-removebg-preview.png') }}" alt=""
                                style="height: 18px; margin-left:-5px;" /> First Year
                        </p>
                    </div>
                    <div>
                        <p class="mt-3" style="font-size: 14px !important">
                            <strong class="fw-bold"><i class="fa-solid fa-business-time"></i> Member Since:</strong>
                            {{ isset($product->vendor->company->updated_at) ? date('M, Y', strtotime($product->vendor->company->updated_at)) : 'N/A' }}

                        </p>

                        <p class="mt-3 d-flex" style="font-size: 14px !important">
                            <strong class="fw-bold me-2"><i class="fa-solid fa-location-dot"></i></strong>
                            {{ isset($product->vendor->street) ? $product->vendor->street . ', ' : '' }}
                            {{ isset($product->vendor->house_no) ? $product->vendor->house_no . ', ' : '' }}
                            {{ isset($product->vendor->city) ? $product->vendor->city : '' }},{{ isset($product->state->name) ? $product->state->name : '' }},{{ isset($product->country->name) ? $product->country->name : '' }}
                            {{ isset($product->vendor->zip) ? $product->vendor->zip : '' }}
                        </p>


                        <p class="px-0 mb-2 mx-0 mt-3 d-flex justify-content-start align-items-center">
                            <strong class="fw-bold me-2"><i class="fa-solid fa-globe"></i></strong>
                            <small
                                class="me-3">{{ isset($product->country->name) ? $product->country->name : '' }}</small>
                            <img src="https://flagcdn.com/40x30/{{ strtolower($product->country->iso2) }}.png"
                                alt="" style="height: 1rem" />
                        </p>
                    </div>
                </div>
            </div>
            <style>
                .fontp {
                    font-size: 14px !important;
                }
            </style>
            <div class="card send_msg_supplier mt-1">
                <div class="card-body pb-0">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <p class="fw-bolder fontp">Shipping:</p>
                        </div>
                        <div class="col-md-8">
                            <p class="fontp">
                                <strong class="fw-bolder">

                                    @if(isset($yourShippingCost['shipping_cost']))

                                    {{-- FREE SHIPPING --}}
                                    @if($yourShippingCost['shipping_cost'] == 0)
                                    Free International Shipping

                                    {{-- PAID SHIPPING --}}
                                    @else

                                    {{-- COUNTRY LEVEL --}}
                                    @if(!empty($data['countries']) && count($data['countries']) > 0)

                                    <div style="color:#FF7519;">Cost by Country:</div>
                                    <div class="shipping-list" id="country-list">

                                        @foreach($data['countries'] as $index => $country)
                                        @php $currencyVar = "currency".$index; @endphp

                                        <div class="shipping-item {{ $index >= 3 ? 'd-none more-country' : '' }}">
                                            {{ $country['name'] }} :
                                            {{ $product->$currencyVar ?? 'USD' }}$
                                            {{ number_format($country['cost'], 2) }}
                                        </div>
                                        @endforeach

                                    </div>

                                    @if(count($data['countries']) > 3)
                                    <button class="btn btn-primary mt-2 show-more"
                                        data-target="more-country"
                                        data-scroll="country-list">
                                        More
                                    </button>
                                    @endif


                                    {{-- REGION LEVEL --}}
                                    @elseif(!empty($data['regions']) && count($data['regions']) > 0)

                                    <div style="color:#FF7519;">Cost by Region:</div>
                                    <div class="shipping-list" id="region-list">

                                        @foreach($data['regions'] as $index => $region)
                                        <div class="shipping-item {{ $index >= 3 ? 'd-none more-region' : '' }}">
                                            <strong>{{ $region['name'] }}</strong> :
                                            USD${{ number_format($region['cost'], 2) }}
                                        </div>
                                        @endforeach

                                    </div>

                                    @if(count($data['regions']) > 3)
                                    <button class="btn btn-primary mt-2 show-more"
                                        data-target="more-region"
                                        data-scroll="region-list">
                                        More
                                    </button>
                                    @endif

                                    @else
                                    No Shipping Zone
                                    @endif

                                    @endif
                                    @endif

                                </strong>
                            </p>
                            <p class="text-muted" style="font-size: 12px">
                                Located in:
                                {{ isset($product->item_country->name) ? $product->item_country->name : '' }}
                            </p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p class="fw-bolder fontp">Returns:</p>
                        </div>
                        <div class="col-md-8">
                            <p class="fontp">
                                @if (isset($product->product_setting->isReturnAccept) && $product->product_setting->isReturnAccept == 1)
                                <strong class="fw-semibold">{{ $product->product_setting->return_timeline }} Days returns.
                                    {{ $product->product_setting->seller_pay == 1 ? 'Seller pay for return shipping.' : 'Buyer pay for return shipping.' }}</strong>
                                @else
                                No Return Accepted
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="fw-bolder fontp">Payments:</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                @if (isset($product->paymentInfo->isPayPal) && $product->paymentInfo->isPayPal == 1)
                                <div class="col-6 mb-2">
                                    <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                        <img src="{{ asset('world-business/images/icons/1156727_finance_payment_paypal_icon.png') }}"
                                            style="  height: 100%; width: 100%;  object-fit: contain; object-position: center; "
                                            alt="" />
                                    </div>
                                </div>
                                @endif
                                @if (isset($product->paymentInfo->isGooglePay) && $product->paymentInfo->isGooglePay == 1)
                                <div class="col-6 mb-2">
                                    <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                        <img src="{{ asset('world-business/images/icons/7123945_logo_pay_google_gpay_icon.png') }}"
                                            style=" height: 100%; width: 100%; object-fit: contain; object-position: center; "
                                            alt="" />
                                    </div>
                                </div>
                                @endif
                                @if (isset($product->paymentInfo->isBankDetail) && $product->paymentInfo->isBankDetail == 1)
                                <div class="col-6 mb-2">
                                    <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                        <img src="{{ asset('uploads/logo/bank.png') }}"
                                            style=" height: 100%; width: 100%; object-fit: contain; object-position: center; "
                                            alt="" />
                                    </div>
                                </div>
                                @endif
                                @if (isset($product->paymentInfo->isOther) && $product->paymentInfo->isOther == 1)
                                <div class="col-6 mb-2">
                                    <div class="rounded-2" style="height: 40px; border: 1px solid black">
                                        <img src="{{ asset('apple-pay.png') }}"
                                            style=" height: 100%; width: 100%; object-fit: contain; object-position: center; "
                                            alt="" />
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (isset($product->vendor->sellerPackageOne->package->type) && ($product->vendor->sellerPackageOne->package->type=="gold" || $product->vendor->sellerPackageOne->package->type=="platinum"))
            <a href="{{ route('seller.spotlight', $product->vendor->ref_no) }}"
                class="btn m-2 btn-primary d-block">Visit
                Supplier Spotlight Store</a>
            @else
            <a href="{{ route('seller.profile.view', $product->vendor->ref_no) }}"
                class="btn m-2 btn-primary d-block">Visit
                Supplier Business Profile</a>
            @endif
        </div>

        <div class="col-md-9 mt-0" id="shipmentinfo">
            <div class="row mt-4">
                <div class="col-md-12 mt-4">
                    <h4 class="my-2 mb-4 fw-bold fs-4">Return policy</h4>
                    <div class="table-responsive">
                        @if (isset($product->product_setting->seller_pay) &&
                        $product->product_setting->seller_pay == 1 &&
                        $product->product_setting->isReturnAccept == 1)
                        <table class="table">
                            <thead>
                                <tr class="table-active">
                                    <th>Seller accept return within</th>
                                    <th>Refund will be given as</th>
                                    <th>Return shipping</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $product->product_setting->return_timeline }} Days</td>
                                    <td>{{ $product->product_setting->refund }}</td>
                                    <td>Seller pays for return shipping</td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <table class="table">
                            <thead>
                                <tr class="table-active">
                                    <th>Seller don't accept return</th>
                                </tr>
                            </thead>

                        </table>
                        @endif
                    </div>

                </div>
                <div class="col-md-12 mt-4">
                    <h4 class="my-2 fw-bold fs-4">Payment Details</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-active">
                                    <th>Payment methods</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            @if (isset($product->paymentInfo->isPayPal) && $product->paymentInfo->isPayPal == 1)
                                            <div style="height: 45px; width: 70px; border: 1px solid black;"
                                                class="rounded-2 me-2">
                                                <img src="{{ asset('world-business/images/icons/1156727_finance_payment_paypal_icon.png') }}"
                                                    class="h-100 w-100"
                                                    style="object-fit: contain; object-position: center;"
                                                    alt="" />
                                            </div>
                                            @endif
                                            @if (isset($product->paymentInfo->isGooglePay) && $product->paymentInfo->isGooglePay == 1)
                                            <div
                                                style="height: 45px; width: 70px; border: 1px solid black; " class="rounded-2 me-2">
                                                <img src="{{ asset('world-business/images/icons/1156750_finance_mastercard_payment_icon.png') }}"
                                                    class="h-100 w-100"
                                                    style=" object-fit: contain; object-position: center; "
                                                    alt="" />
                                            </div>
                                            @endif
                                            @if (isset($product->paymentInfo->isBankDetail) && $product->paymentInfo->isBankDetail == 1)
                                            <div style=" height: 45px; width: 70px; border: 1px solid black; "
                                                class="rounded-2 me-2">
                                                <img src="{{ asset('uploads/logo/bank.png') }}"
                                                    class="h-100 w-100"
                                                    style=" object-fit: contain;  object-position: center; "
                                                    alt="" />
                                            </div>
                                            @endif
                                            @if (isset($product->paymentInfo->isOther) && $product->paymentInfo->isOther == 1)
                                            <div style=" height: 45px; width: 70px; border: 1px solid black; "
                                                class="rounded-2 me-2">
                                                <img src="{{ asset('apple-pay.png') }}"
                                                    class="h-100 w-100"
                                                    style=" object-fit: contain;  object-position: center; "
                                                    alt="" />
                                            </div>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('external-user.inc-parts.listCard')
<div class="mt-3 px-3">
    <button type="button" onclick="window.history.back()" class="btn btn-primary text-light">
        <i class="fas fa-arrow-left"></i> Back
    </button>
</div>

@php
$imageGallery = json_decode($product->mainGallery);
@endphp
@endsection
@section('custom-js-external')

<script>
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('show-more')) {

            const targetClass = e.target.dataset.target;
            const scrollId = e.target.dataset.scroll;

            document.querySelectorAll('.' + targetClass)
                .forEach(el => el.classList.remove('d-none'));

            e.target.remove();

            document.getElementById(scrollId)
                ?.scrollIntoView({
                    behavior: 'smooth'
                });
            $('#nav-shipping-pay-tab').click();
        }
    });

    function startCountdown() {
        let countdownElement = document.getElementById("ends_in");
        let endDate = countdownElement.getAttribute("data-end");
        let countDownDate = new Date(endDate).getTime();

        function updateCountdown() {
            let now = new Date().getTime();
            let distance = countDownDate - now;

            if (distance < 0) {
                countdownElement.innerHTML = "Expired";
                clearInterval(interval);
                return;
            }

            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = `Ends in ${days}d ${hours}h ${minutes}m ${seconds}s `;
        }

        updateCountdown(); // Initial call
        let interval = setInterval(updateCountdown, 1000);
    }

    document.addEventListener("DOMContentLoaded", startCountdown);
</script>


<script>
    const productVariants = @json($variants ?? []);
    const productGallery = @json($imageGallery ?? []);
    const defaultSelection = @json($defaultSelection ?? []);
</script>
<script>
    $(document).ready(function() {

        $(".small-view").on("click", function() {
            var newSrc = $(this).attr("src");
            $(".large-view").attr("src", newSrc);
        });


    });

    function toggleShipmentInfo() {
        $("#shipmentinfo").toggleClass("d-none");
    }

    function productDetail() {
        $("#shipmentinfo").removeClass("d-none");
    }

    function imageVideo() {
        $("#shipmentinfo").removeClass("d-none");
    }
</script>
<script>
    $(document).ready(function() {
        // Function to check the selected combination and update preview
        var imGallery = $('#gl-images');
        const imgUrll = "{{ asset('uploads/products/') }}/";

        if (productGallery.length > 0 && productGallery[0] != undefined) {
            imGallery.empty();
            productGallery.forEach(image => {
                imGallery.append(
                    `<div class="col-md-2 mt-3">
                                <img class="small-view h-100 w-100" src="${imgUrll + image?.image}" alt="Thumbnail" />
                             </div>`
                );
            });
        }

        function updatePreview() {
            // Gather selected attributes
            imGallery.empty();
            const selectedAttributes = {};
            $(".attribute-select").each(function() {
                const attribute = $(this).data("attribute");
                const value = $(this).val();
                if (value) {
                    selectedAttributes[attribute] = value;
                }
            });

            // Find matching variant
            let matchedVariant = null;

            for (const variant of productVariants) {
                const attributes = variant.attributes || {};
                let isMatch = true;

                for (const key in selectedAttributes) {
                    if (attributes[key] !== selectedAttributes[key]) {
                        isMatch = false;
                        break;
                    }
                }
                imGallery.empty();
                productVariants.forEach(function(variant) {
                    glimgs = variant.images || [];
                    glimgs.forEach(function(img) {
                        imGallery.append(
                            `<div class="col-md-2 mt-3">
                                        <img class="small-view h-100 w-100" src="${imgUrll + img}" alt="Thumbnail" />
                                     </div>`
                        );
                    });
                });

                if (isMatch) {
                    matchedVariant = variant;
                    break;
                }
            }


            const defaultImage = "{{ asset('uploads/pngwing.com (18).png') }}";
            const imgUrl = "{{ asset('uploads/products/') }}/";
            const smallGallery = $("#smallGallery").empty();

            if (matchedVariant) {
                const images = matchedVariant.images || [];
                const priceProduct = matchedVariant.price || 0;
                const qtyProduct = matchedVariant.quantity || 0;
                const soldQtyProduct = matchedVariant.sold_quantity || 0;

                $('#priceMultiply').text('US$ ' + parseFloat(priceProduct).toFixed(2));
                $('#priceVariant').val(parseFloat(priceProduct).toFixed(2));

                $("#avQty").text(qtyProduct - soldQtyProduct);
                $("#avsoldQty").text(soldQtyProduct + ' sold');
                $("#qty").attr("max", qtyProduct);
                $("#qty").attr("min", 1);
                if (qtyProduct - soldQtyProduct <= 0) {
                    $("#qty").attr("disabled", true);
                    $("#btn-group-action").addClass('d-none');
                    $("#unavailableQty").removeClass('d-none');

                } else {
                    $("#qty").attr("disabled", false);
                    $("#btn-group-action").removeClass('d-none');
                    $("#unavailableQty").addClass('d-none');
                }
                if (images.length > 0) {
                    $(".large-view").attr("src", imgUrl + images[0]);
                    images.forEach(image => {
                        smallGallery.append(
                            `<div class="in-img">
                                <img class="small-view" src="${imgUrl + image}" alt="Thumbnail" />
                            </div>`
                        );
                    });
                } else {
                    if (productGallery.length > 0 && productGallery[0] != undefined) {
                        $(".large-view").attr("src", imgUrl + productGallery[0]?.image);
                        productGallery.forEach(image => {
                            smallGallery.append(
                                `<div class="in-img">
                                        <img class="small-view" src="${imgUrl + image?.image}" alt="Thumbnail" />
                                     </div>`
                            );
                        });
                    } else {
                        $(".large-view").attr("src", defaultImage);
                    }
                }
            } else {
                $(".large-view").attr("src", defaultImage);
            }
            $(".small-view").on("click", function() {
                $(".large-view").attr("src", $(this).attr("src"));
            });
        }
        $(".attribute-select").on("change", updatePreview);
        for (const key in defaultSelection) {
            $("#" + key).val(defaultSelection[key]);
        }
        $(".attribute-select").trigger("change");
    });
</script>
<script>
    document.getElementById('prevBtn').addEventListener('click', function() {
        const gallery = document.querySelector('.in-img-wrapper');
        gallery.scrollBy({
            left: -150,
            behavior: 'smooth'
        });
    });

    document.getElementById('nextBtn').addEventListener('click', function() {
        const gallery = document.querySelector('.in-img-wrapper');
        gallery.scrollBy({
            left: 150,
            behavior: 'smooth'
        });
    });
</script>


<script>
    $(document).on('click', '.add-to-cart', function() {

        const $btn = $(this);
        const productId = $btn.data('id');
        const quantity = $('#qty').val();
        const priceMultiply = $('#priceVariant').val();

        let variant = {};
        $('.attribute-select').each(function() {
            const attr = $(this).data('attribute');
            const val = $(this).val();
            if (val) variant[attr] = val;
        });

        $btn.prop('disabled', true);

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                variant: variant,
                priceMultiply: priceMultiply,
                _token: '{{ csrf_token() }}',
            },
            success(response) {

                if (response.success) {

                    $('#add_to_cart_val').text(response.cartCount);

                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart',
                        text: response.message
                    });

                } else {
                    Swal.fire({
                        title: 'Login Required',
                        text: response.message,
                        confirmButtonText: 'Sign in',
                        confirmButtonColor: '#FF7519'
                    }).then(() => {
                        window.location.href = "{{ route('login') }}";
                    });
                }
            },
            error(xhr) {
                Swal.fire('Error', 'Something went wrong!', 'error');
            },
            complete() {
                $btn.prop('disabled', false);
            }
        });
    });
</script>
<script>
    $(document).on('click', '.add-to-cart1', function() {
        const productId = $(this).data('id');
        const quantity = $('#qty').val();
        const priceMultiply = $('#priceVariant').val();
        const variant = {};

        $('.attribute-select').each(function() {
            const attr = $(this).data('attribute');
            const value = $(this).val();
            if (value) {
                variant[attr] = value;
            }
        });
        // console.log(quantity);
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                variant: variant,
                priceMultiply: priceMultiply,
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "Congratulation!",
                        text: response?.message,
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: "<h5 class='fw-bolder fs-5'>To use this option you need to</h5>",
                        text: "",
                        icon: "",
                        draggable: true,
                        confirmButtonText: "Sign in",
                        confirmButtonColor: "#FF7519",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "{{ route('login') }}";
                        }
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
                toastr.error('Failed to add product to cart');
            },
        });
    });
</script>
<script>
    $(document).on('click', '.checkout-now', function() {
        const productId = $(this).data('id');
        const quantity = $('#qty').val();
        const priceMultiply = $('#priceVariant').val();
        const variant = {};

        $('.attribute-select').each(function() {
            const attr = $(this).data('attribute');
            const value = $(this).val();
            if (value) {
                variant[attr] = value;
            }
        });
        // console.log(quantity);
        $.ajax({
            url: '{{ route("checkoutNow") }}',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                variant: variant,
                priceMultiply: priceMultiply,
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response?.success) {

                    toastr.success(response?.message);
                    window.location.href = response?.url;
                } else {
                    Swal.fire({
                        title: "<h5 class='fw-bolder fs-5'>To use this option you need to</h5>",
                        text: "",
                        icon: "",
                        draggable: true,
                        confirmButtonText: "Sign in",
                        confirmButtonColor: "#FF7519",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "{{ route('login') }}";
                        }
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
                toastr.error('Failed to add product to cart');
            },
        });
    });
</script>
@endsection