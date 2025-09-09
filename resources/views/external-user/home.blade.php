@extends('external-user.external-frame')

@section('meta_data')
    @if (isset(auth()->user()->account_type) && auth()->user()->account_type == 'seller')
        <title>For Sellers – World Business Guide – Your international Market</title>
        <meta name="description"
            content="Join Millions Trading on one of the World`s largest B2B & B2C E-Commerce Platform and Promote your Products to Buyers across the Globe.">
        <meta name="keywords" content="For Sellers, Trading, E-Commerce, Promotion, B2B, B2C, Worldwide">
        <meta name="author" content="WBG24.com">
    @elseif (isset(auth()->user()->account_type) && auth()->user()->account_type == 'buyer')
        <title>For Buyers – WBG24.com – Your international Market</title>
        <meta name="description"
            content="Buying Products, Limited Offers, Bulk Buying, Daily Deals & Hot Products for Best Prices, contact trusted Suppliers and bid on Tenders or Request for Quotation.">
        <meta name="keywords" content="Limited Offers, Bulk Buying, Daily Deals, Hot Products, Trusted Suppliers">
        <meta name="author" content="WBG24.com">
    @else
        <title>World Business Guide – WBG24.com – Your international Market</title>
        <meta name="description"
            content="Buy & Trade with Manufacturer, Wholesaler & Retailer across the Globe on World`s largest B2B & B2C E-Commerce Platform WBG24.com - Your international Market.">
        <meta name="keywords" content="Trade, Manufacturer, Wholesaler, Retailer, B2B, B2C, International Market">
        <meta name="author" content="WBG24.com">
    @endif
@endsection

@section('external-main-content')
 
    <style>
        .scroll_listing::-webkit-scrollbar {
            width: 8px;
        }

        .scroll_listing::-webkit-scrollbar-thumb {
            background-color: #9b9999;
            border-radius: 10px;
        }

        .scroll_listing::-webkit-scrollbar-thumb:hover {
            background-color: #b8b8b8;
        }

        .accordion-button:focus,
        .accordion-button:hover {
            box-shadow: unset !important;
            border: 0px !important;
            background-color: unset !important;
            color: #000 !important;
        }

        .accordion-button {
            color: #000 !important;
            background-color: #fff !important;
            padding: 5px !important;
            border: none !important;
            box-shadow: unset !important;
            outline: none !important;
            font-size: 15px !important;
            font-weight: normal !important;
        }

        .accordion-body {
            padding: 5px 0px !important;
            padding-left: 5px !important;
        }

        .accordion-body ul {
            margin-left: 0px !important;
            padding-left: 0px !important;
            color: #000 !important;
        }

        .accordion-body ul li {
            margin-bottom: 10px !important;
            font-size: 15px !important;
            line-height: 1 !important;
        }

        .accordion-body ul li a {
            color: #000 !important;

        }

        .accordion-button .icon {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            content: "\f067";
            /* Unicode for plus icon */
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        /* Expanded state: Minus icon */
        .accordion-button:not(.collapsed) .icon {
            content: "\f068";
            /* Unicode for minus icon */
        }

        .accordion-button::after {
            content: none !important;
            background: none !important;
        }

        .accordion {
            border: none !important;
        }

        .accordion-item {
            border: none !important;
        }

        .product-card {
    text-align: center; /* Centers everything inside */
  }
  .product-card img {
    display: block;
    margin: 0 auto; /* Ensures image is centered */
  }
  .product-title,
  .product-price {
    text-align: center; /* Explicit center alignment for title & price */
  }
    </style>
    <!-- main home banner section start here -->
    <section class="container-fluid mt-2 mb-0 main-banner-slider">
        <div id="home-banner" class="owl-carousel h-100 w-100">
            @foreach ($banners as $banner)
                <a href="{{ $banner['banner_link'] }}" class="banner-slide ">
                    <img class="img-fluid" src="{{ asset('uploads/home_banners/' . $banner['banner']) }}" alt="" />
                </a>
            @endforeach
        </div>
    </section>
    <!-- main home banner section end here -->

    <!-- top features sections start here -->
    <section class="container-fluid d-md-block d-none shadow mt-0 bg-white text-center pt-5 pb-5">
        <div class="row features-card">
            <div class="col-md-4 col-sm-12">
                <div class="box my-2">
                    <a class="page-scroll" href="#featur1">
                        <i class="fa fa-compass yo-2" aria-hidden="true"></i>
                        Discover Products Suppliers
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="box my-2">
                    <a class="page-scroll" href="#featur2">
                        <i class="fa fa-star yo-2" aria-hidden="true"></i> Latest Products</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="box my-2">
                    <a class="page-scroll" href="#featur3">
                        <i class="fa fa-life-ring yo-2" aria-hidden="true"></i> Top
                        Suppliers And Agents</a>
                </div>
            </div>
        </div>
    </section>
    <!-- top features sections end here -->

    <div class="container-fluid my-4" id="featur1">
        <div class="row">
            <div class="col-md-4 mt-2">
                <div class="card equal-box shadow category-list">
                    <div class="first-category-heading d-flex justify-content-between">
                        <span class="icon-category">
                            <i aria-hidden="true" class="fa fa-bars"></i>
                            <span class="mx-2">Products by Category</span>
                        </span>
                        <div id="back-button" style="display: none;cursor: pointer;">
                            <i id="back-category" class="fa-solid fa-arrow-left "></i>
                        </div>
                    </div>
                    <ul class="listing scroll_listing px-0" id="category-list"
                        style="height:35rem;overflow-y:scroll;scroll-behavior: smooth;">
                        <div class="accordion" id="categoryAccordion">
                            @foreach ($categoryTree as $parentCategory)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingParent{{ $parentCategory['id'] }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseParent{{ $parentCategory['id'] }}" aria-expanded="true"
                                            aria-controls="collapseParent{{ $parentCategory['id'] }}">
                                            {{ $parentCategory['name'] }}
                                            <i class="fas fa-angle-right icon"></i>
                                        </button>
                                    </h2>
                                    <div id="collapseParent{{ $parentCategory['id'] }}" class="accordion-collapse collapse "
                                        aria-labelledby="headingParent{{ $parentCategory['id'] }}"
                                        data-bs-parent="#categoryAccordion">
                                        <div class="accordion-body">
                                            @if (!empty($parentCategory['categories']))
                                                @include('external-user.inc-parts.category-accordion', [
                                                    'categories' => $parentCategory['categories'],
                                                    'parentId' => $parentCategory['id'],
                                                ])
                                            @else
                                                <ul class="list-unstyled px-0">
                                                    <li>
                                                        <a
                                                            href="{{ $parentCategory['route'] }}">{{ $parentCategory['name'] }}</a>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </ul>



                    <!-- Pass all categories and subcategories as a JSON object -->
                    <script type="text/javascript">
                        var categoriesData = {!! json_encode($categories) !!};
                    </script>

                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="card equal-box shadow">
                    <h3 class="mid-card-heading">
                        <a href="#">
                            <img src="{{ asset('uploads/icons/icon1.png') }}" class="rfq_img" />
                            <span>{!! $infos[1]->title !!}</span>
                        </a>
                    </h3>
                    <div class="describe text-center mb-0">
                        {!! $infos[1]->sub_title !!}
                    </div>
                    <div class="new-deatils">
                        <div class="img-content">
                            <a href="" target="_self">
                                <img class="img-fluid img-thumbnail"
                                    src="{{ asset('uploads/home_banners/' . $infos[1]->image) }}" alt />
                            </a>
                        </div>

                        {!! $infos[1]->content !!}
                    </div>

                    <div class="w-100">
                        <a class="btn btn-primary w-100" href="{{ route('benefits.buyers') }}">Get Quote</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <div class="card equal-box shadow">
                    <div class="product-group">
                        <h3 class="mid-card-heading">
                            <a href="#">
                                <img src="{{ asset('uploads/icons/icon2.png') }}" class="rfq_img" />
                                <span class>New Members </span>
                            </a>
                        </h3>
                        <div class="describe">
                            <a class="text-primary" href="">Global Brands Converge Here</a>
                        </div>
                        @foreach ($wholesalerUsers as $wholesalerUser)
                            <a class="small_product_card mt-2 p-2 row"
                                href="{{ route('seller.profile.view', $wholesalerUser->company->slug) }}"
                                title="{{ isset($wholesalerUser->company->name) ? $wholesalerUser->company->name : 'NA' }}">
                                <div class="col-3">
                                    <span class="round_img">
                                        <img style="height:2rem; width:auto;"
                                            src="@if (isset($wholesalerUser->company->company_logo) && $wholesalerUser->company->company_logo != '') {{ asset('uploads/profile/' . $wholesalerUser->company->company_logo) }}
                                                    @else
                                                    {{ asset('uploads/logo/default-logo.png') }} @endif"
                                            class="lazyloaded" />
                                    </span>
                                </div>
                                <div class="col-9 product_named">
                                    <div>
                                        <h6 class="product_title text-every fw-bolder">
                                            {{ isset($wholesalerUser->company->name) ? $wholesalerUser->company->name : 'NA' }}
                                        </h6>

                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- section start for featured products -->
    <section class="container-fluid mb-4" id="featur2">
        <div class="card rounded-0 shadow bg-white">
            <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4">
                <span class="fs-5 fw-bold text-every">Latest Products</span>
                <a href="{{ route('all.products') }}" class="text-every">View More</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="owl-carousel" id="featured_products">
                        @if (isset($latestProducts))
                            @foreach ($latestProducts as $latestProduct)
                                @php
                                    $variants = is_string($latestProduct->variants)
                                        ? json_decode($latestProduct->variants, true)
                                        : $latestProduct->variants;
                                    $variants = is_array($variants) ? $variants : [];
                                    $allImages = [];

                                    foreach ($variants as $variant) {
                                        if (!empty($variant['images']) && is_array($variant['images'])) {
                                            $allImages = array_merge($allImages, $variant['images']);
                                        }
                                    }

                                    $previewImage = !empty($allImages)
                                        ? asset('uploads/products/' . $allImages[0])
                                        : null;
                                    if($latestProduct->isListingType=="spotlight"){
                                                  $mainGallery = is_string($latestProduct->mainGallery)
                                                    ? json_decode($latestProduct->mainGallery, true)
                                                    : $latestProduct->mainGallery;
                                                  
                                                  $mainGallery = is_array($mainGallery) ? $mainGallery : [];
                                                  $imgg=isset($mainGallery[0]['image'])?asset(
                                                                'uploads/products/'.$mainGallery[0]['image']):asset('uploads/pngwing.com (18).png');
                                                  $flImg=$imgg;
                                                  
                                                }else{
                                                  $flImg='https://placehold.co/600x400';
                                                }    
                                    if (empty($previewImage)) {
                                        $previewImage =
                                            isset($latestProduct->gallery[0]->image) &&
                                            !empty($latestProduct->gallery[0]->image)
                                                ? asset('uploads/products/gallery/' . $latestProduct->gallery[0]->image)
                                                : $flImg;
                                    }
                                @endphp

                                <a href="{{ route('product.detail', $latestProduct->slug) }}"
                                    class="card text-dark  p-2 border-0 product-card">
                                    <div class="w-100 d-flex justify-content-center">
                                        <img src="
                                           @if (isset($previewImage)) {{ $previewImage }} @endif
                                        "class="rounded-2"
                                            style="height: 8rem; width: 8rem" alt="" />
                                    </div>
                                    <div class="card-body">
                                        <p class="product-title">
                                            {{ $latestProduct->name }}
                                        </p>
                                        <span class="text-primary product-price d-block">
                                            Price at: $

                                            {{ number_format($latestProduct->minPrice, 2) }}

                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end featured products -->


    <!-- section start for Latest Buy tenders -->
    <section class="container-fluid mb-4">
        <div class="card shadow rounded-0 bg-white">
            <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4">
                <span class="fs-5 fw-bold text-every">Latest Tenders</span>
                <a href="{{ route('all.tenders') }}" class="text-every">View More</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="owl-carousel" id="latest_bclassifieds">
                        @if (isset($latestTenders))
                            @foreach ($latestTenders as $ltender)
                                <div class="card p-2 border-0 product-card">
                                    <div class="w-100 d-flex justify-content-center">
                                        <img src="@if (isset($ltender->image_1) && $ltender->image_1 != '') {{ asset('uploads/tender/' . $ltender->image_1) }} @else https://placehold.co/400x400 @endif"
                                            class="rounded-2" style="height: 8rem; width: 8rem" alt="" />
                                    </div>
                                    <div class="card-body pt-0">
                                        <p class="product-title">
                                            {{ $ltender->name }}
                                        </p>
                                        <span class="text-primary product-price d-block">
                                            Price at: ${{ $ltender->price }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end latest tenders -->

    <!-- section start for Top Suppliers And Agents -->
    <section class="container-fluid mb-4" id="featur3">
        <div class="card shadow rounded-0 bg-white">
            <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4">
                <span class="fs-5 fw-bold text-every">Top Suppliers And Agents</span>
                <a href="{{ route('all.suppliers') }}" class="text-every">View More</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="owl-carousel" id="top_suppliers">
                        @if (isset($top_suppliers))
                            @foreach ($top_suppliers as $tsupplier)
                                <a href="{{ route('seller.profile.view', $tsupplier->company->slug) }}"
                                    class="card p-2 border-0"  >
                                    <div class="w-100 d-flex justify-content-center">
                                        <img src="@if (isset($tsupplier->company->company_logo) && $tsupplier->company->company_logo != '') {{ asset('uploads/profile/' . $tsupplier->company->company_logo) }}
                                                    @else
                                                    {{ asset('uploads/logo/default-logo.png') }} @endif"
                                            class="card-img-top" style="height: 8rem; width: 8rem" alt="" />
                                    </div>
                                    <div class="card-body px-2">
                                        <p>{{ $tsupplier->company->name ?? $tsupplier->first_name }}</p>
                                        <span
                                            class="text-secondary mt-2 d-block fw-bold fs-6">{{ $tsupplier->total_sold }}+
                                            Products sold</span>
                                    </div>

                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end Top Suppliers And Agents -->

    <!-- section start for Limited Offers -->
    <section class="container-fluid mb-4">
        <div class="card shadow rounded-0 bg-white">
            <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4">
                <span class="fs-5 fw-bold text-every">Limited Offers</span>
                <a href="{{ route('all.type.products', 'limited-offer') }}" class="text-every">View More</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="owl-carousel" id="limited_offers">
                        @if ($LimitedProducts)
                            @foreach ($LimitedProducts as $LimitedProduct)
                                @php
                                    $minPrice = 0;
                                    $variants = is_string($LimitedProduct->variants)
                                        ? json_decode($LimitedProduct->variants, true)
                                        : $LimitedProduct->variants;
                                    $variants = is_array($variants) ? $variants : [];
                                    $allImages = [];

                                    foreach ($variants as $variant) {
                                        if (!empty($variant['images']) && is_array($variant['images'])) {
                                            $allImages = array_merge($allImages, $variant['images']);
                                        }
                                    }

                                    $previewImage = !empty($allImages)
                                        ? asset('uploads/products/' . $allImages[0])
                                        : null;
                                    if($LimitedProduct->isListingType=="spotlight"){
                                                  $mainGallery = is_string($LimitedProduct->mainGallery)
                                                    ? json_decode($LimitedProduct->mainGallery, true)
                                                    : $LimitedProduct->mainGallery;
                                                  
                                                  $mainGallery = is_array($mainGallery) ? $mainGallery : [];
                                                  $imgg=isset($mainGallery[0]['image'])?asset(
                                                                'uploads/products/'.$mainGallery[0]['image']):asset('uploads/pngwing.com (18).png');
                                                  $flImg=$imgg;
                                                  
                                                }else{
                                                  $flImg='https://placehold.co/600x400';
                                                }        
                                    if (empty($previewImage)) {
                                        $previewImage =
                                            isset($LimitedProduct->gallery[0]->image) &&
                                            !empty($LimitedProduct->gallery[0]->image)
                                                ? asset(
                                                    'uploads/products/gallery/' . $LimitedProduct->gallery[0]->image,
                                                )
                                                :$flImg;
                                    }
                                @endphp
                                
<a href="{{ route('product.detail', $LimitedProduct->slug) }}"
   class="card p-2 text-dark border-0 product-card text-center">
    <div class="w-100 d-flex justify-content-center">
        <img src="{{ $previewImage }}" class="rounded-2"
             style="height: 8rem; width: 8rem; object-fit: contain;" alt="" />
    </div>
    <div class="card-body d-flex flex-column align-items-center justify-content-center p-2">
        <p class="product-title mb-1 text-center">
            {{ $LimitedProduct->name }}
        </p>
        <span class="text-primary product-price d-block text-center">
            Price at: ${{ number_format($LimitedProduct->minPrice, 2) }}
        </span>
    </div>
</a>

                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end Limited Offers -->

    <!-- section start cards -->
    <section class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12 py-4 text-center">
                <h3 class="fs-5 text-bolder py-2 text-every">
                    Daily Deals By Sellers
                </h3>
                <small class="small text-every">Offers, Sales and Discounts</small>
            </div>
            <div class="col-md-4">
                <div class="card shadow p-md-4 p-2 rounded-0 bg-white">
                    <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4 pt-1">
                        <span class="fs-5 fw-bold text-every">Bulk Buying</span>
                        <a href="{{ route('all.type.products', 'bulk-buying') }}" class="text-every">View More</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="owl-carousel" id="bulk_buying">
                                @if ($BulkProducts)
                                    @foreach ($BulkProducts as $BulkProduct)
                                        @php
                                            $variants = is_string($BulkProduct->variants)
                                                ? json_decode($BulkProduct->variants, true)
                                                : $BulkProduct->variants;
                                            $variants = is_array($variants) ? $variants : [];
                                            $allImages = [];

                                            foreach ($variants as $variant) {
                                                if (!empty($variant['images']) && is_array($variant['images'])) {
                                                    $allImages = array_merge($allImages, $variant['images']);
                                                }
                                            }

                                            $previewImage = !empty($allImages)
                                                ? asset('uploads/products/' . $allImages[0])
                                                : null;
                                                if($BulkProduct->isListingType=="spotlight"){
                                                  $mainGallery = is_string($BulkProduct->mainGallery)
                                                    ? json_decode($BulkProduct->mainGallery, true)
                                                    : $BulkProduct->mainGallery;
                                                  
                                                  $mainGallery = is_array($mainGallery) ? $mainGallery : [];
                                                  $imgg=isset($mainGallery[0]['image'])?asset(
                                                                'uploads/products/'.$mainGallery[0]['image']):asset('uploads/pngwing.com (18).png');
                                                  $flImg=$imgg;
                                                  
                                                }else{
                                                  $flImg='https://placehold.co/600x400';
                                                }   
                                            if (empty($previewImage)) {
                                                $previewImage =
                                                    isset($BulkProduct->gallery[0]->image) &&
                                                    !empty($BulkProduct->gallery[0]->image)
                                                        ? asset(
                                                            'uploads/products/gallery/' .
                                                                $BulkProduct->gallery[0]->image,
                                                        )
                                                        : $flImg;
                                            }
                                        @endphp
                                        <a href="{{ route('product.detail', $BulkProduct->slug) }}"
                                            class="card text-dark p-2 border-0 product-card">
                                            <div class="w-100 d-flex justify-content-center">
                                                <img src="{{ $previewImage }}" class="rounded-2"
                                                    style="height: 8rem; width: 8rem" alt="" />
                                            </div>
                                            <div class="card-body">
                                                <p class="product-title">
                                                    {{ $BulkProduct->name }}
                                                </p>
                                                <span class="text-primary product-price d-block text-center">
                                                    Price at: $

                                                    {{ number_format($BulkProduct->minPrice, 2) }}

                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow p-md-4 p-2 rounded-0 bg-white">
                    <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4 pt-1">
                        <span class="fs-5 fw-bold text-every">Daily Deals</span>
                        <a href="{{ route('all.type.products', 'daily-deals') }}" class="text-every">View More</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="owl-carousel" id="daily_deals">
                                @if ($DailyProducts)
                                    @foreach ($DailyProducts as $DailyProduct)
                                        @php
                                            $variants = is_string($DailyProduct->variants)
                                                ? json_decode($DailyProduct->variants, true)
                                                : $DailyProduct->variants;
                                            $variants = is_array($variants) ? $variants : [];
                                            $allImages = [];

                                            foreach ($variants as $variant) {
                                                if (!empty($variant['images']) && is_array($variant['images'])) {
                                                    $allImages = array_merge($allImages, $variant['images']);
                                                }
                                            }

                                            $previewImage = !empty($allImages)
                                                ? asset('uploads/products/' . $allImages[0])
                                                : null;
                                                if($DailyProduct->isListingType=="spotlight"){
                                                  $mainGallery = is_string($DailyProduct->mainGallery)
                                                    ? json_decode($DailyProduct->mainGallery, true)
                                                    : $DailyProduct->mainGallery;
                                                  
                                                  $mainGallery = is_array($mainGallery) ? $mainGallery : [];
                                                  $imgg=isset($mainGallery[0]['image'])?asset(
                                                                'uploads/products/'.$mainGallery[0]['image']):asset('uploads/pngwing.com (18).png');
                                                  $flImg=$imgg;
                                                  
                                                }else{
                                                  $flImg='https://placehold.co/600x400';
                                                }   
                                            if (empty($previewImage)) {
                                                $previewImage =
                                                    isset($DailyProduct->gallery[0]->image) &&
                                                    !empty($DailyProduct->gallery[0]->image)
                                                        ? asset(
                                                            'uploads/products/gallery/' .
                                                                $DailyProduct->gallery[0]->image,
                                                        )
                                                        : $flImg;
                                            }
                                        @endphp
                                        <a href="{{ route('product.detail', $DailyProduct->slug) }}"
                                            class="card text-dark p-2 border-0 product-card">
                                            <div class="w-100 d-flex justify-content-center">
                                                <img src="{{ $previewImage }}" class="rounded-2"
                                                    style="height: 8rem; width: 8rem" alt="" />
                                            </div>
                                            <div class="card-body">
                                                <p class="product-title">
                                                    {{ $DailyProduct->name }}
                                                </p>
                                                <span class="text-primary product-price d-block">
                                                    Price at: $

                                                    {{ number_format($DailyProduct->minPrice, 2) }}

                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow p-md-4 p-2 rounded-0 bg-white">
                    <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4 pt-1">
                        <span class="fs-5 fw-bold text-every">Hot Product</span>
                        <a href="{{ route('all.type.products', 'hot') }}" class="text-every">View More</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="owl-carousel" id="hot_product">
                                @if ($HotsProducts)
                                    @foreach ($HotsProducts as $HotsProduct)
                                        @php
                                            $variants = is_string($HotsProduct->variants)
                                                ? json_decode($HotsProduct->variants, true)
                                                : $HotsProduct->variants;
                                            $variants = is_array($variants) ? $variants : [];
                                            $allImages = [];
                                            foreach ($variants as $variant) {
                                                if (!empty($variant['images']) && is_array($variant['images'])) {
                                                    $allImages = array_merge($allImages, $variant['images']);
                                                }
                                            }

                                            $previewImage = !empty($allImages)
                                                ? asset('uploads/products/' . $allImages[0])
                                                : null;
                                                 if($HotsProduct->isListingType=="spotlight"){
                                                  $mainGallery = is_string($HotsProduct->mainGallery)
                                                    ? json_decode($HotsProduct->mainGallery, true)
                                                    : $HotsProduct->mainGallery;
                                                  
                                                  $mainGallery = is_array($mainGallery) ? $mainGallery : [];
                                                  $imgg=isset($mainGallery[0]['image'])?asset(
                                                                'uploads/products/'.$mainGallery[0]['image']):asset('uploads/pngwing.com (18).png');
                                                  $flImg=$imgg;
                                                  
                                                }else{
                                                  $flImg='https://placehold.co/600x400';
                                                }   
                                            if (empty($previewImage)) {
                                                $previewImage =
                                                    isset($HotsProduct->gallery[0]->image) &&
                                                    !empty($HotsProduct->gallery[0]->image)
                                                        ? asset(
                                                            'uploads/products/gallery/' .
                                                                $HotsProduct->gallery[0]->image,
                                                        )
                                                        : $flImg;
                                            }
                                        @endphp
                                        <a href="{{ route('product.detail', $HotsProduct->slug) }}"
                                            class="card text-dark p-2 border-0 product-card">
                                            <div class="w-100 d-flex justify-content-center">
                                                <img src="{{ $previewImage }}" class="rounded-2"
                                                    style="height: 8rem; width: 8rem" alt="" />
                                            </div>
                                            <div class="card-body">
                                                <p class="product-title">
                                                    {{ $HotsProduct->name }}
                                                </p>
                                                <span class="text-primary product-price d-block">
                                                    Price at: $

                                                    {{ number_format($HotsProduct->minPrice, 2) }}

                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->

    <!-- section start for Spotlight Stores -->
    <section class="container-fluid mb-4">
        <div class="card shadow rounded-0 bg-white">
            <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4">
                <span class="fs-5 fw-bold text-every">Spotlight Stores</span>
                <a href="{{ route('all.spotlight') }}" class="text-every">View More</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="owl-carousel" id="spotlight_stores">
                        @foreach ($spotlights as $spotlight)
                            <a href="{{ route('seller.spotlight', $spotlight->ref_no) }}" class="d-block text-primary">
                                <div class="card p-1 rounded-0" style="border:5px solid #cfcfcf">
                                    <div class="banner position-relative" style="width: 100% !important;">
                                        <img class="w-100"
                                            src="{{ asset('uploads/profile/' . $spotlight->company->spotlight_banner) }}"
                                            alt="">
                                        <div class="position-absolute bg-white p-1 rounded-1 "
                                            style="height:2.4rem; width:2.4rem; left:50%; transform:translateX(-50%); bottom:-1%;">
                                            @if (isset($spotlight->company->company_logo) && $spotlight->company->company_logo != '')
                                                <img class="h-100 w-100"
                                                    src="{{ asset('uploads/profile/' . $spotlight->company->company_logo) }}"
                                                    alt="" style="object-fit: contain;">
                                            @else
                                                <img class="h-100 w-100"
                                                    src="{{ asset('uploads/logo/default-logo.png') }}" alt=""
                                                    style="object-fit: contain;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row g-2 mt-3  image-grid">
                                        @if(isset($spotlight->company->spotlight_preview1) && $spotlight->company->spotlight_preview1!="")
                                        <div class="col-3">
                                            <img class="rounded-1"
                                                src="{{ asset('uploads/profile/' . $spotlight->company->spotlight_preview1) }}"
                                                alt="Image 1">
                                        </div>
                                        @endif
                                        @if(isset($spotlight->company->spotlight_preview2) && $spotlight->company->spotlight_preview2!="")
                                        <div class="col-3">
                                            <img class="rounded-1"
                                                src="{{ asset('uploads/profile/' . $spotlight->company->spotlight_preview2) }}"
                                                alt="Image 2">
                                        </div>
                                        @endif
                                        @if(isset($spotlight->company->spotlight_preview3) && $spotlight->company->spotlight_preview3!="")
                                        <div class="col-3">
                                            <img class="rounded-1"
                                                src="{{ asset('uploads/profile/' . $spotlight->company->spotlight_preview3) }}"
                                                alt="Image 3">
                                        </div>
                                        @endif
                                        @if(isset($spotlight->company->spotlight_preview4) && $spotlight->company->spotlight_preview4!="")
                                        <div class="col-3">
                                            <img class="rounded-1"
                                                src="{{ asset('uploads/profile/' . $spotlight->company->spotlight_preview4) }}"
                                                alt="Image 4">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <h6 class="mt-2 text-center"> {{ $spotlight->company->name ?? '....' }} </h6>
                                <div class="d-flex mt-2 justify-content-center">
                                    @php
                                        $rating = $spotlight->average_rating ?? 0;
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
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end Top Suppliers And Agents -->

    <!-- section start info cards -->
    <section class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card shadow p-1 rounded-0 bg-white">
                    <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4">
                        <span class="fs-5 fw-bold text-every">Latest News</span>
                        <a href="{{ route('all.news.show') }}" class="text-every">View More</a>
                    </div>
                    <div class="card-body overflow-y-scroll news_scroll">
                        @foreach ($latestNews as $news)
                            <a href="{{ route('read.news', $news->slug) }}" class="row text-dark news_card">
                                <div class="col-md-3">

                                    <img src="
                                    @if (isset($news->image) && $news->image != null) {{ asset('uploads/news/' . $news->image) }}
                                         @else
                                       https://placehold.co/200 @endif
                                    "
                                        alt="{{ $news->title }}" />

                                </div>
                                <div class="col-md-9">
                                    <div class="news_details">
                                        <h4>
                                            {{ $news->title }}
                                        </h4>
                                        <p>
                                            {{ $news->short_description }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-1 rounded-0 bg-white">
                    <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4 pb-0">
                        <span class="fs-5 fw-bold text-every">Products Video Show</span>
                        <a href="{{ route('all.product-video.show') }}" class="text-every">View More</a>
                    </div>
                    <div class="card-body news_scroll mb-4">
                        @if (isset($videoProduct->id))
                            <a class="text-dark fw-bold fs-6 text-center"
                                href="{{ route('product.detail', $videoProduct->slug) }}">
                                <h6>{{ $videoProduct->name }}</h6>
                            </a>
                            <div class="mt-3 mx-auto " style="height: 9.5rem; width: 80%;">
                                <video id="my-video" class="video-js vjs-default-skin" controls preload="auto"
                                    style="height: 100%; width:100%">
                                    <source
                                        src="{{ asset('uploads/products/videos/' . $videoProduct->video->video_url) }}"
                                        type="video/mp4" />
                                    <p class="vjs-no-js">To view this video please enable JavaScript, and consider
                                        upgrading to a web browser that supports HTML5 video</p>
                                </video>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card shadow p-1 rounded-0 bg-white">
                    <div class="card-header border-bottom-0 bg-white d-flex justify-content-between py-4">
                        <span class="fs-5 fw-bold text-every">Find Suppliers by Region</span>
                        <a href="{{ route('all.supplier.region') }}" class="text-every">View More</a>
                    </div>
                    <div class="card-body news_scroll overflow-y-scroll">
                        <div class="row h-100 ">
                            @foreach ($countries as $country)
                                <a href="{{ route('all.suppliers') }}?country={{ $country->name }}"
                                    class="col-md-3 col-sm-4 col-6 mb-3 d-flex text-dark flex-column align-items-center justify-content-center">
                                    <img src="https://flagcdn.com/48x36/{{ strtolower($country->iso2) }}.png"
                                        class="img-fluid" alt="" />
                                    <small class="fw-bold pt-2"
                                        style="font-size: 12px !important;white-space:nowrap;">{{ $country->name }}</small>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->

    <!-- section start for working steps -->
    <section class="container-fluid mb-4">
        <div class="row">

            <div class="col-md-12 mt-4">
                <div class="card shadow p-md-5 p-0 rounded-0">
                    <div class="row align-items-center">
                        <div class="col-md-5 ">
                            <img src="{{ asset('uploads/home_banners/' . $infos[0]->image) }}"
                                class="img-fluid rounded-2" alt="" />
                        </div>
                        <div class="col-md-7 px-3 py-2 ">
                            <h3 class="fs-3  fw-bold text-every">
                                {{ $infos[0]->title }}
                            </h3>
                            <small>{{ $infos[0]->sub_title }}</small>

                            <p class="mt-2">{!! $infos[0]->content !!}</p>
                            <a href="{{ route('user.member.package') }}" class="btn btn-secondary mt-3">Join Member
                                Package</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- section end for working steps -->

    <!-- section start for featured brands -->
    <section class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3 class="fs-3 py-2 fw-bold text-every"> {!! $infos[2]->title !!} </h3>
                <p class="fs-5 text-every">
                    {!! $infos[2]->sub_title !!}
                </p>
            </div>
            <div class="col-md-12 mt-4">
                <div class="card shadow p-md-5 p-0 rounded-0">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="p-2">
                                <p class="paragraph-text">
                                    {!! $infos[2]->content !!}
                                </p>
                                <a href="https://www.click-coin.eu" target="_blank" class="mt-4 btn btn-primary">Invest &
                                    Profit</a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <img src="{{ asset('uploads/home_banners/' . $infos[2]->image) }}" class="img-fluid"
                                alt="" />
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    @include('external-user.inc-parts.listCard')
@endsection
@section('custom-js-external')
    <script>
        var player = videojs('my-video', {
            controls: true,
            autoplay: false,
            preload: 'auto',
            loop: false,
            muted: false,
            fluid: false
        });
    </script>
@endsection
