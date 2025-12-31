@extends('external-user.external-frame')


@section('meta_data')
<title>Find the newest Products across the Globe on World Business Guide</title>
<meta name="description"
    content="On WBG24.com you will find more than 7000 specific Product Categories with the newest and best Price Products from trusted Suppliers across the Globe.">
<meta name="keywords" content="Newest Products, latest Products, best Price Products, Multiply Products">
<meta name="author" content="WBG24.com">
@endsection


@section('external-main-content')
<section class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-sm-4 d-flex justify-content-end align-items-start sidebar">
            <nav class="navbar  navbar-expand-lg w-100">
                <p></p>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form method="get" action="{{ route('all.products') }}" class="collapse w-100 navbar-collapse mx-0"
                    style="margin-top: 1rem !important" id="navbarSupportedContent">
                    <div class="w-100">
                        <h5 class="btn btn-primary d-flex  align-items-center">
                            <i class="fas fa-filter me-2"></i> Filter
                        </h5>
                        <input type="hidden" name="filter-type" value="{{ $_GET['filter-type'] ?? '' }}">
                        <input type="hidden" name="q" value="{{ $_GET['q'] ?? '' }}">
                        <div class="accordion my_filters w-100" id="accordionExample">
                            <div class="accordion-item pt-2 w-100">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <a href="#" class="d-flex align-items-center">
                                            <span class="me-2">
                                                <i class="fas fa-money-bill"></i>
                                            </span>
                                            <span>By Price</span>
                                        </a>
                                        <span class="collapse-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body px-0">
                                        <div class="form-group mb-4">
                                            <input type="text" class="form-control form-control-sm"
                                                placeholder="Minimum Price" value="{{ $_GET['min_price'] ?? '' }}"
                                                name="min_price" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm"
                                                placeholder="Maximum Price" value="{{ $_GET['max_price'] ?? '' }}"
                                                name="max_price" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item pt-2 w-100">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <a href="#" class="d-flex align-items-center">
                                            <span class="me-2">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </span>
                                            <span>By Area</span>
                                        </a>
                                        <span class="collapse-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body px-0">
                                        <div class="form-group ">
                                            <select id="selectCountry" name="country"
                                                class="form-control form-control-sm">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->name }}" @selected(isset($_GET['country']) && $_GET['country']==$country->name)>
                                                    {{ $country->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item pt-2 w-100">
                                <h2 class="accordion-header" id="headingThree">
                                    <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <a href="#" class="d-flex align-items-center">
                                            <span class="me-2">
                                                <i class="fa-solid fa-bars"></i>
                                            </span>
                                            <span>By Categories</span>
                                        </a>
                                        <span class="collapse-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body px-0" id="category_container">
                                        <div class="form-group mb-2">
                                            <select class="form-control form-control-sm" name="parentcategory"
                                                id="category_level1">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(isset($_GET['parentcategory']) && $_GET['parentcategory']==$category->id)>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item pt-2 w-100">
                                <h2 class="accordion-header" id="headingSix">
                                    <button type="button" class="collapse-btn" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        <a href="#" class="d-flex align-items-center">
                                            <span class="me-2">
                                                <i class="fa-solid fa-trophy"></i>
                                            </span>
                                            <span>By Business Type</span>
                                        </a>
                                        <span class="collapse-icon">+</span>
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body px-0">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" name="business_type">
                                                @php
                                                $businessTypes = [
                                                'Manufacturer',
                                                'Wholesaler',
                                                'Retailer',
                                                'Service Provider',
                                                ];
                                                @endphp
                                                <option value="">Business Type</option>
                                                @foreach ($businessTypes as $type)
                                                <option @selected(isset($_GET['business_type']) && $type==$_GET['business_type']) value="{{ $type }}">
                                                    {{ $type }}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary mt-3 d-block w-100">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </nav>
        </div>
        <div class="col-md-8 mb-4">
            <!-- Products -->
            <nav aria-label="breadcrumb" class="mb-2 mt-4 d-flex align-items-center justify-content-between">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-primary">Back</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-primary">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Products
                    </li>
                </ol>

                <div>
                    <select class="form-control form-select" name="order_type" id="order_type">
                        <option @selected(request('order_type')=="all" ) value="all">All Products</option>
                        <option @selected(request('order_type')=="multiply" ) value="multiply">Multiply Products</option>
                        <option @selected(request('order_type')=="single" ) value="single">Single Products</option>
                        <option @selected(request('order_type')=="expired-soon" ) value="expired-soon">Ending Soonest</option>
                        <option @selected(request('order_type')=="latest" ) value="latest">Newly Listed</option>
                    </select>
                </div>
            </nav>

            <div class="row">
                @forelse ($products ?? [] as $product)
                <div class="col-md-12 mt-4">
                    <div class="card shadow rounded-0">
                        <div class="row">
                            <div class="col-md-3 sm-border-right">
                                <div class="product_img">
                                    @php
                                    // Decode variants safely
                                    $variants = is_string($product->variants)
                                    ? json_decode($product->variants, true)
                                    : $product->variants;
                                    $variants = is_array($variants) ? $variants : [];

                                    // Collect all images from combinations
                                    $allImages = [];
                                    foreach ($variants as $variant) {
                                    if (!empty($variant['images']) && is_array($variant['images'])) {
                                    $allImages = array_merge($allImages, $variant['images']);
                                    }
                                    }

                                    // Pick the first valid image
                                    $previewImage = !empty($allImages)
                                    ? asset('uploads/products/' . $allImages[0])
                                    : null;
                                    if($product->isListingType=="spotlight"){
                                    $mainGallery = is_string($product->mainGallery)
                                    ? json_decode($product->mainGallery, true)
                                    : $product->mainGallery;

                                    $mainGallery = is_array($mainGallery) ? $mainGallery : [];
                                    $imgg=isset($mainGallery[0]['image'])?asset(
                                    'uploads/products/'.$mainGallery[0]['image']):asset('uploads/pngwing.com (18).png');
                                    $flImg=$imgg;

                                    }else{
                                    $flImg='https://placehold.co/600x400';
                                    }
                                    // Fallback to gallery or placeholder
                                    if (empty($previewImage)) {
                                    $previewImage =
                                    isset($product->gallery[0]->image) &&
                                    !empty($product->gallery[0]->image)
                                    ? asset(
                                    'uploads/products/gallery/' .
                                    $product->gallery[0]->image,
                                    )
                                    : $flImg;
                                    }
                                    @endphp
                                    <img style="height: 10rem; width: 100%; object-fit: contain"
                                        src="{{ $previewImage }}" />
                                </div>
                            </div>
                            <div class="col-md-6 sm-border-right">
                                <div class="row product_describes">
                                    <a href="{{ route('product.detail', $product->slug) }}">
                                        <h3 class="fs-6 text-dark fw-bolder text-center">
                                            {{ $product->name }}
                                        </h3>
                                    </a>
                                    <h3 class="fs-5 fw-bolder my-4 mt-2 mb-0 text-center text-secondary">
                                        @if ($product->minPrice != '' && $product->minPrice == $product->maxPrice)
                                        US$ {{ $product->minPrice ?? 0 }}
                                        @else
                                        US$ {{ $product->minPrice ?? 0 }} - US$ {{ $product->maxPrice ?? 0 }}
                                        @endif

                                    </h3>
                                    <p class="text-center fw-bolder pt-1 mt-0 fs-6">
                                        Min. Order 1 Pieces
                                    </p>
                                    <h5 class="text-center fw-bolder fs-6 mt-2 text-primary ">
                                        {{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $product->item_condition) }}
                                    </h5>
                                    <h5 class="text-center fw-bolder fs-6 mt-2 text-primary1">
                                        @if($product->totalQty > 0)
                                        {!! ($product->totalQty - $product->sold_quantity) !!}
                                        available
                                        / <span class="text-danger">
                                            {{ max(0, $product->sold_quantity) }} Sold
                                        </span>
                                        @else
                                        soldout
                                        @endif
                                        @php
                                        if($product->duration>0)

                                        $start = \Carbon\Carbon::parse($product->created_at);
                                        $end = $start->copy()->addDays($product->duration);
                                        $now = \Carbon\Carbon::now();

                                        if ($now->gte($end)) {
                                        $expired = true;
                                        } else {
                                        $expired = false;
                                        $remainingSeconds = $now->diffInSeconds($end);

                                        $days = intdiv($remainingSeconds, 86400);
                                        $remainingSeconds %= 86400;

                                        $hours = intdiv($remainingSeconds, 3600);
                                        $remainingSeconds %= 3600;

                                        $minutes = intdiv($remainingSeconds, 60);
                                        $seconds = $remainingSeconds % 60;
                                        }
                                        @endphp

                                        @if($expired)
                                        /<span class="expired"> Expired</span>
                                        @else
                                        /<span class="time-left">
                                            <strong>Ends in</strong>
                                            @if($days > 0)
                                            {{ $days }}d {{ $hours }}h
                                            @elseif($hours > 0)
                                            {{ $hours }}h {{ $minutes }}m
                                            @elseif($minutes > 0)
                                            {{ $minutes }}m {{ $seconds }}s
                                            @else
                                            {{ $seconds }}s
                                            @endif
                                        </span>
                                        @endif



                                    </h5>


                                    <div class="text-center flex-wrap icon_product">
                                        @php
                                        $icons = isset($product->vendor->symbols)
                                        ? $product->vendor->symbols
                                        : '';
                                        @endphp
                                        @if ($icons)
                                        @if ($icons->isTradeAssurance)
                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Trade Assurance">
                                            <img src="{{ asset('world-business/images/icons/ic1.jpg') }}"
                                                style="height: 40px" />
                                        </a>
                                        @endif

                                        @if ($icons->isTrustSeal)
                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Trust Seal">
                                            <img src="{{ asset('world-business/images/icons/ic2.jpg') }}"
                                                style="height: 40px" />
                                        </a>
                                        @endif
                                        @if ($icons->isAssessedSupplier)
                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Assessed Supplier">
                                            <img src="{{ asset('world-business/images/icons/ic3.jpg') }}"
                                                style="height: 40px" />
                                        </a>
                                        @endif
                                        @if ($icons->isOnsiteChecked)
                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Onsite Checked (Advance)">
                                            <img src="{{ asset('world-business/images/icons/ic4.jpg') }}"
                                                style="height: 40px" />
                                        </a>
                                        @endif

                                        @if ($icons->isProductVerified)
                                        <a href="" class="light-green" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Production Verified">
                                            <img src="{{ asset('world-business/images/icons/ic5.jpg') }}"
                                                style="height: 40px" alt="Production Verified" />
                                        </a>
                                        @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 position-relative">
                                <div class="position-absolute text-center"
                                    style="top: 30px; right: 50%; transform: translateX(50%)">
                                    <img
                                        src="https://flagcdn.com/40x30/{{ strtolower($product->country->iso2) }}.png" />
                                    <p class="text-dark  fw-bold">{{ $product->country->name }}</p>
                                    <div class="d-flex mt-2 justify-content-center">
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
                                    <h5 class="text-center fw-bolder fs-6 mt-2 text-primary">
                                        {{ isset($product->vendor->company->name) ? $product->vendor->company->name : '' }}
                                    </h5>


                                </div>

                                <div class="position-absolute"
                                    style="bottom: 30px;right: 50%;transform: translateX(50%);">
                                    <p class="text-center text-muted">
                                        <span class="text-primary">
                                            {{ isset($product->vendor->company->business_type) ? $product->vendor->company->business_type : '' }}
                                        </span>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @if (request('q') != '')
                <h4 class="text-danger fw-bold text-center mt-3">Sorry! search products not found!</h4>
                @else
                <h4 class="text-danger fw-bold text-center mt-3">No Products have been listed in this Category up to yet … <br>If you`re a matched Product Seller for this Category, use it and be one Step ahead of your Competitors …</h4>
                @endif
                @endforelse

            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center ">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <h5 class="fs-6 pt-5 text-primary text-center">
                Premium Related Products
            </h5>
            <div class="row">
                @if ($premiumProducts)
                @foreach ($premiumProducts ?? [] as $item)
                @php
                // Decode variants safely
                $variants = is_string($item->variants)
                ? json_decode($item->variants, true)
                : $item->variants;
                $variants = is_array($variants) ? $variants : [];

                // Collect all images from combinations
                $allImages = [];
                foreach ($variants as $variant) {
                if (!empty($variant['images']) && is_array($variant['images'])) {
                $allImages = array_merge($allImages, $variant['images']);
                }
                }

                // Pick the first valid image
                $previewImage = !empty($allImages) ? asset('uploads/products/' . $allImages[0]) : null;

                // Fallback to gallery or placeholder
                if (empty($previewImage)) {
                $previewImage =
                isset($item->gallery[0]->image) && !empty($item->gallery[0]->image)
                ? asset('uploads/products/gallery/' . $item->gallery[0]->image)
                : 'https://placehold.co/600x400';
                }
                @endphp
                <div class="col-md-12 right_panel_list">
                    <a href="{{ route('product.detail', $item->slug) }}" target="_blank"
                        class="product-link">
                        <div class="right_img">
                            <img class="img-fluid" src="{{ $previewImage }}" alt="{{ $item->name }}" />
                        </div>
                    </a>
                    <a href="{{ route('product.detail', $item->slug) }}"
                        class="product_title fs-6 fw-bold text-primary">{{ $item->name }}</a>
                    <span class="product_price text-secondary">
                        @if ($item->minPrice != '' && $item->minPrice == $item->maxPrice)
                        US$ {{ $item->minPrice ?? 0 }}
                        @else
                        US$ {{ $item->minPrice ?? 0 }} - US$ {{ $item->maxPrice ?? 0 }}
                        @endif
                    </span>
                </div>
                @endforeach
                @endif

            </div>
        </div>
    </div>
</section>
@include('external-user.inc-parts.listCard')
@endsection
@section('custom-js-external')
<script>
    function getLevel2() {
        var categoryId = $('#category_level1').val();
        var level2 = "{{ $_GET['subcategory'] ?? '' }}";
        if (categoryId) {
            $.ajax({
                url: '{{ route("public.get.childcategory") }}',
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
                            '<div class="form-group mb-2" id="category_level22">' +
                            '<select name="subcategory" id="category_level2" class="form-select form-select-sm">' +
                            '<option value="">Select Sub Category</option>';
                        $.each(response, function(index, subCategory) {
                            var selected = subCategory.id == level2 ? 'selected' : '';
                            subcategoryHtml += '<option ' + selected + ' value="' + subCategory
                                .id + '">' + subCategory.name + '</option>';
                        });
                        subcategoryHtml += '</select></div>';
                        $('#category_container').append(
                            subcategoryHtml);
                        getLevel3();
                    }
                }
            });
        } else {
            $('#category_container').find('#category_level22')
                .remove();
            $('#category_container').find('#category_level33')
                .remove();
            $('#category_container').find('#category_level44')
                .remove();
        }
    }

    function getLevel3() {
        var subCategoryId = $('#category_level2').val();
        var level3 = "{{ $_GET['childcategory'] ?? '' }}";

        if (subCategoryId) {
            $.ajax({
                url: '{{ route("public.get.childcategory") }}',
                type: 'POST',
                data: {
                    sub_category_id: subCategoryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.length > 0) {

                        $('#category_container').find('#category_level33')
                            .remove();
                        $('#category_container').find('#category_level44')
                            .remove();

                        var subSubCategoryHtml =
                            '<div class="form-group mb-2" id="category_level33">' +
                            '<select name="childcategory" id="category_level3" class="form-select form-select-sm">' +
                            '<option value="">Select Child Category</option>';
                        $.each(response, function(index, subSubCategory) {
                            var selected = subSubCategory.id == level3 ? 'selected' : '';
                            subSubCategoryHtml += '<option ' + selected + ' value="' +
                                subSubCategory.id + '">' + subSubCategory.name +
                                '</option>';
                        });
                        subSubCategoryHtml += '</select></div>';
                        $('#category_container').append(
                            subSubCategoryHtml);
                        getLevel4();
                    }
                }
            });

        } else {
            $('#category_container').find('#category_level33')
                .remove();
            $('#category_container').find('#category_level44')
                .remove();
        }
    }

    function getLevel4() {
        var subSubCategoryId = $('#category_level3').val();
        var level4 = "{{ $_GET['endcategory'] ?? '' }}";
        if (subSubCategoryId) {
            $.ajax({
                url: '{{ route("public.get.childcategory") }}',
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
                            '<div class="form-group mb-2" id="category_level44">' +
                            '<select name="endcategory" id="category_level4" class="form-select form-select-sm">' +
                            '<option value="">Select End Category</option>';
                        $.each(response, function(index, childCategory) {
                            var selected = childCategory.id == level4 ? 'selected' : '';
                            childCategoryHtml += '<option ' + selected + ' value="' +
                                childCategory.id + '">' + childCategory.name +
                                '</option>';
                        });
                        childCategoryHtml += '</select></div>';
                        $('#category_container').append(
                            childCategoryHtml); // Append to category_container
                    }
                }
            });
        } else {
            $('#category_container').find('#category_level44')
                .remove();
        }
    }

    $(document).ready(function() {

        // When parent category is selected
        $('#category_level1').change(function() {
            getLevel2();
        });
        getLevel2();

        // When subcategory is selected
        $(document).on('change', '#category_level2', function() {
            getLevel3();
        });

        // When sub-subcategory is selected
        $(document).on('change', '#category_level3', function() {
            getLevel4();
        });



    });
</script>
<script>
    $('#order_type').on('change', function() {
        let selected = $(this).val();
        let url = new URL(window.location.href);
        url.searchParams.set('order_type', selected);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection