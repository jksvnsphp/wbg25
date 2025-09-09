@extends('external-user.external-frame')
@section('meta_data')
    <title>{{ $seller->profile_meta->title ?? 'WBG24' }}</title>
    <meta name="description" content="{{ $seller->profile_meta->description ?? 'No Description' }}">
    <meta name="keywords"
        content="{{ $seller->profile_meta->keywords ?? '' }} 
    @for ($i = 1; $i <= 10; $i++) {{ $seller['company']['key' . $i] ?? '' }}, @endfor
    ">
    <meta name="author" content="{{ $seller->company->name ?? '' }}">
@endsection
@section('external-main-content')
    <style>
        .clamped-text {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            -webkit-line-clamp: 1;
        }

        .clamped-text2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
            -webkit-line-clamp: 2;
        }
    </style>
    <!-- information section -->
    @if (isset($seller->company->profile_banner) && $seller->company->profile_banner != '')
        @php
            $bg =
                'background: url(' .
                asset('uploads/profile/' . $seller->company->profile_banner) .
                '); background-position:center !important; background-repeat:no-repeat !important;';
        @endphp
    @endif
    <section class="w-100 py-5 hero_bg" style="{{ $bg ?? '' }}">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="card bg-transparent rounded-0 border-0">
                        <div class="card-body">
                            <h4 class="fw-bolder text-light py-4 pt-5">{{ $seller->first_name . ' ' . $seller->last_name }}
                            </h4>
                            <div class="mt-5">
                                <p class="text-light">
                                    <i class="fa fa-location"></i>
                                    {{ $seller->city . ', ' . $seller->state->name . ', ' . $seller->country->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-img d-flex justify-content-center my-3 mb-2">
                            <img src="@if (isset($seller->profile) && $seller->profile != '') {{ asset('uploads/profile/' . $seller->profile) }}
                                @else
                                    https://www.shutterstock.com/image-vector/vector-design-avatar-dummy-sign-600nw-1290556063.jpg @endif"
                                style="height: 5.5rem" alt="" />
                        </div>

                        <h5 class="text-center fw-bolder pb-5 pt-3">{{ $seller->first_name . ' ' . $seller->last_name }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- company information -->
    <section class="w-100 my-4">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="d-flex justify-content-around align-items-center">
                    <p></p>
                    <h5 class="fw-bold text-center py-3 pb-1">
                        {{ isset($seller->company->name) ? $seller->company->name : '' }}
                    </h5>
                    <div class="d-flex justify-content-center">
                        <p class="text-center pb-0 mb-0 me-2">{{ isset($seller->country->name) ? $seller->country->name : '' }}
                        </p>
                        <img src="https://flagcdn.com/256x192/{{ strtolower($seller->country->iso2) }}.png" style="height: 20px"
                            alt="" />
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" style="border-right: 1px solid #ddd">
                            <div class="card-img pb-4 d-flex justify-content-center">
                                <img src="@if (isset($seller->company->company_logo) && $seller->company->company_logo != '') {{ asset('uploads/profile/' . $seller->company->company_logo) }}
                                                    @else
                                                    {{ asset('uploads/logo/default-logo.png') }} @endif"
                                    style="height: 6rem !important" alt="" />
                            </div>

                            <!-- <p class="text-center pb-0 mb-0">unknown@example.com</p>
                                                                          <p class="text-center pb-0 mb-0">7877668362</p> -->
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <strong class="fw-bold">Our Business Description</strong>
                                <p>
                                    {{ $seller->company->company_desc ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- image gallery -->
    <section class="w-100 my-4">
        <div class="container-fluid">
            <div class="card rounded-0">
                <h5 class="fw-bold text-center py-3 pb-1">Our Company Images</h5>
                <div class="card-body">
                    <div class="row justify-content-center">
                        @for ($i = 1; $i <= 4; $i++)
                            @if (isset($seller->company['image_' . $i]) && $seller->company['image_' . $i])
                                <div class="col-sm-3">
                                    <div class="card rounded-0 border-0">
                                        <div class="card-img d-flex justify-content-center">
                                            <img src="{{ asset('uploads/profile/' . $seller->company['image_' . $i]) }}"
                                                alt="" style="height: 100%; width: 100%" class="shadow rounded-2" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- company descripyion -->
    <section class="w-100 my-4">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="row justify-content-center">
                    <h5 class="fw-bold text-center py-3 pb-1">Our Company Information</h5>
                    <div class="col-md-12 text-center">
                        <div class="card-body text-center">
                            <ul class="spacer ndspace text-center">
                                <li>
                                    <strong class="fw-bold">Business Type:</strong>
                                    {{ isset($seller->company->business_type) ? $seller->company->business_type : '' }}
                                </li>
                                <li><strong class="fw-bold">Nature of business:</strong> {{ $seller->role }}</li>
                                <li><strong class="fw-bold">Year Company Registered:</strong>
                                    {{ isset($seller->company->company_registeration_year) ? $seller->company->company_registeration_year : '' }}
                                </li>
                                <li><strong class="fw-bold">Key Personnel:</strong>
                                    {{ isset($seller->company->key_personnal) ? $seller->company->key_personnal : '' }}
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- certification achieved -->
    @if (isset($seller->company->isCertificate) && isset($certificates[0]) && $seller->company->isCertificate == 1)
        <section class="w-100 my-4">
            <div class="container-fluid">
                <div class="card rounded-0">
                    <h5 class="fw-bold text-center py-3 pb-1">Certification Achieved</h5>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <p class="mt-0"><strong class="fw-bold">Certification:</strong>
                                        @if (json_decode($seller->company->certifications) != null)
                                            @php
                                                $certifications = json_decode($seller->company->certifications);

                                            @endphp
                                            @foreach ($certifications as $certification)
                                                @if ($certification == 'Other')
                                                    @php
                                                        $other_certificates = json_decode(
                                                            $seller->company->other_certificate,
                                                        );
                                                    @endphp
                                                    @if (isset($other_certificates) && $other_certificates != null)
                                                        @foreach ($other_certificates as $other_certificate)
                                                            @if ($other_certificate != null)
                                                                {{ $other_certificate }},
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @else
                                                    {{ $certification }},
                                                @endif
                                            @endforeach
                                        @endif
                                    </p>
                            @if (isset($certificates) && !empty($certificates))
                                @foreach ($certificates as $certificate)
                                    <div class="col-sm-3">
                                        <div class="card rounded-0 border-0">
                                            <div class="card-img d-flex justify-content-center">
                                                <img src="{{ asset('uploads/certificates/' . $certificate->image) }}"
                                                    alt="" style="height: 100%; width: 100%" class="shadow" />
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- shipment informations -->
    <section class="w-100 my-4 d-none">
        <div class="container-fluid">
            <div class="card rounded-0">
                <h5 class="fw-bold text-center py-3 pb-1">Shipment Information</h5>
                <div class="card-body">
                    <div class="row">
                        <style>
                            .shiplist li {
                                display: flex;

                                margin-top: 10px !important;
                            }

                            .shiplist li strong {
                                margin-right: 5px !important;
                            }
                        </style>
                        @if (isset($seller->company->isShipmentMethod) && $seller->company->isShipmentMethod == 1)

                            <div class="col-md-4" style="border-right: 1px solid #ddd">
                                <h5 class="text-start fw-bold">Shipping Methods</h5>
                                <ul class="px-0 mx-0 shiplist">
                                    <li><strong>Express Delivery Through:</strong> <span>DHL/UPS</span></li>
                                    <li><strong>Package Shipping Through:</strong> <span>DHL/UPS</span></li>
                                    <li><strong>Pallet Shipping Through:</strong> <span>UPS/Shipply.com</span></li>
                                    <li><strong>Insured Shipping:</strong> <span>
                                            @if (isset($seller->company->insured_shipping) && $seller->company->insured_shipping == 1)
                                                <img src="{{ asset('world-business/images/right.png') }}" alt="">
                                            @else
                                                <img src="{{ asset('world-business/images/wrong.png') }}" alt="">
                                            @endif
                                        </span></li>

                                </ul>
                            </div>
                            <div class="col-md-4" style="border-right: 1px solid #ddd">
                                <h5 class="text-start fw-bold">Shipping Processing Time</h5>
                                <ul class="px-0 mx-0 shiplist">
                                    <li><strong>Express Delivery:</strong>
                                        <span>{{ isset($seller->company->express_delivery) ? $seller->company->express_delivery : 0 }}
                                            Day(s)</span>
                                    </li>
                                    <li><strong>Package Shipping:</strong>
                                        <span>{{ isset($seller->company->package_shipping) ? $seller->company->package_shipping : 0 }}
                                            Day(s)</span>
                                    </li>
                                    <li><strong>Pallet Shipping:</strong>
                                        <span>{{ isset($seller->company->pallet_shipping) ? $seller->company->pallet_shipping : 0 }}
                                            Day(s)</span>
                                    </li>
                                    <li><strong>Shipping Notification with Tracking Number:</strong> <span>
                                            @if (isset($seller->company->shipping_notify) && $seller->company->shipping_notify == 1)
                                                <img src="{{ asset('world-business/images/right.png') }}" alt="">
                                            @else
                                                <img src="{{ asset('world-business/images/wrong.png') }}" alt="">
                                            @endif
                                        </span></li>

                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-start fw-bold">Export Region</h5>
                                @if (isset($seller->exports) && !empty($seller->exports))
                                    <ul class="px-0 mx-0">

                                        @if (isset($seller->exports->isWorldWide) && $seller->exports->isWorldWide == 1)
                                            <li><strong>World Wide</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isAfrica) && $seller->exports->isAfrica == 1)
                                            <li><strong>Africa</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isNorthAfrica) && $seller->exports->isNorthAfrica == 1)
                                            <li><strong>North Africa</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isMiddleEast) && $seller->exports->isMiddleEast == 1)
                                            <li><strong>Middle East</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isAsia) && $seller->exports->isAsia == 1)
                                            <li><strong>Asia</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isAustralia) && $seller->exports->isAustralia == 1)
                                            <li><strong>Australia</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isOceania) && $seller->exports->isOceania == 1)
                                            <li><strong>Oceania</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isEuropeanUnion) && $seller->exports->isEuropeanUnion == 1)
                                            <li><strong>European Union</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isRestEuropean) && $seller->exports->isRestEuropean == 1)
                                            <li><strong>Rest of Europe</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isRussianFederation) && $seller->exports->isRussianFederation == 1)
                                            <li><strong>Russian Federation</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isNorthAmerica) && $seller->exports->isNorthAmerica == 1)
                                            <li><strong>North America</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isCentralAmerica) && $seller->exports->isCentralAmerica == 1)
                                            <li><strong>Central America</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        @if (isset($seller->exports->isSouthAmerica) && $seller->exports->isSouthAmerica == 1)
                                            <li><strong>South America</strong> <img
                                                    src="{{ asset('world-business/images/right.png') }}" alt="">
                                            </li>
                                        @endif
                                        <li><strong>Shipping Cost On Demand: </strong> <a href=""
                                                class="btn btn-sm btn-primary">Ask Us</a> </li>
                                    </ul>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- certification achieved -->
    <section class="w-100 my-4">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="row justify-content-center">

                        <div class="col-sm-3">
                            <h6 class="fs-5 fw-bold py-2 text-center">Our Products</h6>
                            @if (isset($latestProduct))
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

                                    // Pick the first valid image
                                    $previewImage = !empty($allImages)
                                        ? asset('uploads/products/' . $allImages[0])
                                        : null;

                                    // Fallback to gallery or placeholder
                                    if (empty($previewImage)) {
                                        $previewImage =
                                            isset($latestProduct->gallery[0]->image) &&
                                            !empty($latestProduct->gallery[0]->image)
                                                ? asset('uploads/products/gallery/' . $latestProduct->gallery[0]->image)
                                                : 'https://placehold.co/600x400';
                                    }
                                @endphp
                                <div class="card shadow pt-2 rounded-0">
                                    <div class="card-img d-flex justify-content-center">
                                        <img src="{{ $previewImage }}" alt="" style="height: 8rem"
                                            class="mx-auto" />
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="{{ route('all.products') }}"
                                            class="text-decoration-none text-primary">View More <i
                                                class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-center">No products available</p>
                            @endif

                        </div>

                        <div class="col-sm-3">
                            <h6 class="fs-5 fw-bold py-2 text-center">Our Tenders</h6>
                            @if (isset($latestTender))
                                <div class="card shadow pt-2 rounded-0">
                                    <div class="card-img d-flex justify-content-center">
                                        <img src="@if (isset($latestTender->image_1) && $latestTender->image_1 != '') {{ asset('uploads/tender/' . $latestTender->image_1) }} @else https://placehold.co/400x400 @endif"
                                            alt="" style="height: 8rem" class="mx-auto" />
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="" class="text-decoration-none text-primary">View More <i
                                                class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-center">No Tender available</p>
                            @endif

                        </div>

                        <div class="col-sm-3">
                            <h6 class="fs-5 fw-bold py-2 text-center">Our News</h6>
                            @if (isset($latestNews))
                                <div class="card pt-2 rounded-0 shadow">
                                    <div class="card-img d-flex justify-content-center">
                                        <img src="@if (isset($latestNews->image) && $latestNews->image != null) {{ asset('uploads/news/' . $latestNews->image) }}
                                         @else https://placehold.co/200 @endif"alt=""
                                            style="height: 8rem" class="mx-auto" />
                                    </div>
                                    <div class="card-body text-center">
                                        <a href="{{ route('all.news.show') }}"
                                            class="text-decoration-none text-primary">View More <i
                                                class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-center">No News available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="w-100 my-4">
        <div class="container-fluid">
            <div class="card rounded-0">
                <h5 class="fw-bold text-center py-3 pb-1">Our Social Media</h5>
                <div class="card-body">
                    <div class="row justify-content-center">
                        @if (isset($seller->social->isFacebook) && $seller->social->isFacebook == 1)
                            <a href="{{ isset($seller->social->facebook) ? $seller->social->facebook : '' }}"
                                class="col-md-1 col-sm-2 col-3 ">
                                <div class="card text-white d-flex justify-content-center align-items-center"
                                    style="background-color: #2525fe; height: 3rem">
                                    <i class="fa-brands fa-facebook-square fs-3"></i>
                                </div>
                            </a>
                        @endif
                        @if (isset($seller->social->isInstagram) && $seller->social->isInstagram == 1)
                            <a href="{{ isset($seller->social->instagram) ? $seller->social->instagram : '' }}"
                                class="col-md-1 col-sm-2 col-3">
                                <div class="card text-white d-flex justify-content-center align-items-center"
                                    style="background: linear-gradient(to bottom, #833ab4, #fd1d1d); height: 3rem;">
                                    <i class="fa-brands fa-instagram fs-3"></i>
                                </div>
                            </a>
                        @endif
                        @if (isset($seller->social->isX) && $seller->social->isX == 1)
                            <a href="{{ isset($seller->social->x) ? $seller->social->x : '' }}"
                                class="col-md-1 col-sm-2 col-3">
                                <div class="card text-white d-flex justify-content-center align-items-center"
                                    style="background-color: #1da1f2; height: 3rem">
                                    <i class="fab fa-twitter fs-3"></i>
                                </div>
                            </a>
                        @endif

                        @if (isset($seller->social->isLinkedIn) && $seller->social->isLinkedIn == 1)
                            <a href="{{ isset($seller->social->linkedin) ? $seller->social->linkedin : '' }}"
                                class="col-md-1 col-sm-2 col-3">
                                <div class="card text-white d-flex justify-content-center align-items-center"
                                    style="background-color: #0077b5; height: 3rem">
                                    <i class="fab fa-linkedin-in fs-3"></i>
                                </div>
                            </a>
                        @endif
                        @if (isset($seller->social->isSkype) && $seller->social->isSkype == 1)
                            <a href="{{ isset($seller->social->skype) ? $seller->social->skype : '' }}"
                                class="col-md-1 col-sm-2 col-3">
                                <div class="card text-white d-flex justify-content-center align-items-center"
                                    style="background-color: #0077b5; height: 3rem">
                                    <img src="{{asset('skype.png')}}" style="height:30px;">
                                </div>
                            </a>
                        @endif
                        @if (isset($seller->social->isYoutube) && $seller->social->isYoutube == 1)
                            <a href="{{ isset($seller->social->youtube) ? $seller->social->youtube : '' }}"
                                class="col-md-1 col-sm-2 col-3">
                                <div class="card text-white d-flex justify-content-center align-items-center"
                                    style="background-color: #b50000; height: 3rem">
                                    <i class="fab fa-youtube fs-3"></i>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- feedback -->
    <section class="w-100 my-4">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="card-header bg-body-secondary">
                    <h5 class="fw-bold text-center pt-1">Our Feedback</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column justify-content-center align-items-start">
                            <h5 class="fw-bold fs-5">Average user rating</h5>
                            <h4 class="fw-bold fs-4 mt-4"><b>{{ $ratingData['averageRating'] ?? 0 }}</b>/5</h4>
                        </div>
                        <div class="col-md-6">
                            <h4 class="feed_top_none">Rating breakdown</h4>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <div style="height: 9px; margin: 5px 0">
                                        5
                                        <i class="fa fa-star text-secondary" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="progress rounded-0" style="height: 9px; margin: 8px 0">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="5"
                                            aria-valuemin="0" aria-valuemax="5"
                                            style="width: {{ $ratingData['fiveStarPercent'] ?? 0 }}%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-start d-flex align-items-center">
                                    {{ $ratingData['fiveStarCount'] ?? 0 }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <div style="height: 9px; margin: 5px 0">
                                        4
                                        <i class="fa fa-star text-secondary" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="progress rounded-0" style="height: 9px; margin: 8px 0">
                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="5"
                                            aria-valuemin="0" aria-valuemax="5"
                                            style="width: {{ $ratingData['fourStarPercent'] ?? 0 }}%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-start d-flex align-items-center">
                                    {{ $ratingData['fourStarCount'] ?? 0 }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <div style="height: 9px; margin: 5px 0">
                                        3
                                        <i class="fa fa-star text-secondary" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="progress rounded-0" style="height: 9px; margin: 8px 0">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="5"
                                            aria-valuemin="0" aria-valuemax="5"
                                            style="width: {{ $ratingData['threeStarPercent'] ?? 0 }}%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-start d-flex align-items-center">
                                    {{ $ratingData['threeStarCount'] ?? 0 }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <div style="height: 9px; margin: 5px 0">
                                        2
                                        <i class="fa fa-star text-secondary" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="progress rounded-0" style="height: 9px; margin: 8px 0">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="5"
                                            aria-valuemin="0" aria-valuemax="5"
                                            style="width: {{ $ratingData['twoStarPercent'] ?? 0 }}%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-start d-flex align-items-center">
                                    {{ $ratingData['twoStarCount'] ?? 0 }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-2">
                                    <div style="height: 9px; margin: 5px 0">
                                        1
                                        <i class="fa fa-star text-secondary" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="progress rounded-0" style="height: 9px; margin: 8px 0">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="5"
                                            aria-valuemin="0" aria-valuemax="5"
                                            style="width: {{ $ratingData['oneStarPercent'] ?? 0 }}%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-start d-flex align-items-center">
                                    {{ $ratingData['oneStarCount'] ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Send your message to this supplier -->
    <section class="w-100 my-4">
        <div class="container-fluid">
            <div class="card rounded-0">
                <div class="card-header bg-body-secondary">
                    <h5 class="fw-bold text-center pt-1">Contact us</h5>
                </div>
                <form method="post" action="{{ route('send.contact.form') }}" id="contact_form" class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="receiver_id" value="{{ $seller->id }}">
                            <div class="form-group mb-2">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name') }}" />
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label for="subject" class="form-label">Subject:</label>
                                <input type="text" name="subject" class="form-control"
                                    value="{{ old('subject') }}" />
                                @error('subject')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-2">
                                <label for="message" class="form-label">Message:</label>
                                <textarea name="message" id="message" class="form-control">{{ old('message') }}</textarea>
                                @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group d-flex flex-column mb-3">
                                <label for="image" class="form-label">Verification Code:</label>
                                <div class="d-flex align-items-center">
                                    {!! captcha_img('flat', ['id' => 'captcha_img']) !!}

                                    <i class="fa-solid fa-rotate mx-3  " onclick="refreshCaptcha()"
                                        style="cursor: pointer !important"></i>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <div class="form-group mb-3">
                                <label for="ver_box" class="form-label">Enter Verification Code in below
                                    box:</label>
                                <input type="text" value="{{ old('captcha') }}" class="form-control" name="captcha"
                                    id="captcha" />
                                @error('captcha')
                                    <p class="text-danger pt-3"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-secondary mt-3">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- sell -->

    @include('external-user.inc-parts.listCard')
@endsection
