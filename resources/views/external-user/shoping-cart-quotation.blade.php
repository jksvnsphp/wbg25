@extends('external-user.external-frame')

@section('external-main-content')
    <section class="container-fluid">
        <div class="row">

            <div class="col-md-12 mb-4">
                <!-- Products -->
                <nav aria-label="breadcrumb" class="mb-2 mt-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Back</a></li>
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Shopping Quotation cart
                        </li>
                    </ol>
                    <div class="d-flex mt-3">
                        <a href="{{ route('cart.product') }}" class="btn btn-primary me-4 position-relative">
                            Products Item
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartOffers ?? 0 }}
                            </span>
                        </a>
                        <a href="{{ route('cart.tender') }}" class="btn btn-primary me-4 position-relative ">
                            Tenders Item
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $tenderOffers ?? 0 }}
                            </span>
                        </a>
                        <a href="{{ route('cart.quotation') }}" class="btn btn-primary position-relative disabled">
                            Quotation Item
                        </a>
                    </div>
                </nav>
                @if ($groupedCarts)
                    @foreach ($groupedCarts as $vendorRef => $groupedCart)
                        @php
                            $carts = $groupedCart['carts'] ?? [];

                            $totalShippingCost = 0;
                            $totalPrice = 0;
                        @endphp
                        <div class="row mt-5">

                            <div class="col-md-9 mb-3">
                                @if ($carts)
                                    @foreach ($carts as $cart)
                                        @php
                                            $seller_logo = 'https://placehold.co/60x60';
                                            $seller_name = 'Unknown';
                                            $seller_shipping_cost = 0;
                                            $totalPrice += $cart->offer_price ?? 0;
                                            if (isset($cart->quotation->vendor->company)) {
                                                $company = $cart->quotation->vendor->company;
                                                if ($company->company_logo != '') {
                                                    $seller_logo = asset('uploads/profile/' . $company->company_logo);
                                                }
                                                $seller_name = $company->name;
                                            }
                                        @endphp

                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                                <div class="card-top d-flex justify-content-between">
                                                    <div class="company-info d-flex">
                                                        <div class="logo me-3">
                                                            <img src="{{ $seller_logo }}" style="height:2rem; width:2rem;"
                                                                alt="Logo">
                                                        </div>
                                                        <div class="company-name">
                                                            <h5 class="card-title fw-bold">{{ $seller_name }}</h5>
                                                            <div class="d-flex justify-content-start">
                                                                @php
                                                                    $rating = $cart->average_rating ?? 0;
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
                                                    <a href="" class="fw-semibold">Only pay this seller (Deal)</a>

                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-2">
                                                        <img src="{{ asset('uploads/quotation/' . $cart->quotation->image_1) }}"
                                                            alt="" class="img-fluid rounded-2">
                                                    </div>
                                                    <div class="col-md-7 d-flex flex-column ">
                                                        <a href="" class="fs-5 mt-4 text-primary fw-bolder">
                                                            {{ $cart->quotation->product_service ?? '' }}
                                                        </a>
                                                        <span class="mt-2 text-secondary text-capitalize">
                                                            {{ preg_replace('/([a-z])([A-Z])|_/', '$1 $2', $cart->quotation->type) }}
                                                        </span>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h5 class="fw-bold text-end fs-4 mt-3">USD
                                                            {{ number_format($cart->offer_price, 2) }}
                                                        </h5>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                            <div class="col-md-3">
                                <div class="card rounded-3 border-0" style="background:rgb(238, 236, 236);">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <strong class="fw-bold">Article (@if ($carts)
                                                    {{ count($carts) }}
                                                @endif)</strong> <strong class="fw-bold">USD
                                                {{ number_format($totalPrice, 2) }}</strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-3">
                                            <strong class="fw-bold">Total</strong> <strong class="fw-bold">USD
                                                {{ number_format($totalPrice, 2) }}</strong>
                                        </div>
                                        <div class="mt-5 mb-3">
                                            <a href="{{ route('checkout.quotation', $vendorRef) }}"
                                                class="btn btn-primary w-100">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @else
                    <h5 class="text-danger fw-bold mt-4">There are currently no Items in your Shopping Cart.</h5>
                @endif
            </div>
        </div>
    </section>
    @include('external-user.inc-parts.listCard')
@endsection
@section('custom-js-external')
@endsection
