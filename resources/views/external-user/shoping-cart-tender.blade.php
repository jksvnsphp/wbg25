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
                            Shopping Tender cart
                        </li>
                    </ol>
                    <div class="d-flex mt-3">
                        <a href="{{ route('cart.product') }}" class="btn btn-primary me-4 position-relative">
                            Products Item
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartOffers ?? 0 }}
                            </span>
                        </a>
                        <a href="{{ route('cart.tender') }}" class="btn btn-primary me-4 position-relative disabled">
                            Tenders Item
                        </a>
                        <a href="{{ route('cart.quotation') }}" class="btn btn-primary position-relative">
                            Quotation Item
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $quotationOffers ?? 0 }}
                            </span>
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
                                            if (isset($cart->tender->vendor->company)) {
                                                $company = $cart->tender->vendor->company;
                                                if ($company->company_logo != '') {
                                                    $seller_logo = asset('uploads/profile/' . $company->company_logo);
                                                }
                                                $seller_name = $company->name;
                                            }
                                            if (isset($cart->yourShippingCost['country'])) {
                                                $seller_shipping_cost = $cart->yourShippingCost['shipping_cost'] ?? 0;
                                                $totalShippingCost += $cart->yourShippingCost['shipping_cost'] ?? 0;
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
                                                        <img src="{{ asset('uploads/tender/'.$cart->tender->image_1) }}" alt=""
                                                            class="img-fluid rounded-2">
                                                    </div>
                                                    <div class="col-md-7 d-flex flex-column ">
                                                        <a href="" class="fs-5 mt-4 text-primary fw-bolder">
                                                            {{ $cart->tender->name ?? '' }}
                                                        </a>
                                                        <span class="mt-2 text-secondary">
                                                            {{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $cart->tender->tender_condition) }}
                                                        </span>
                                                    </div>
                                                  
                                                    <div class="col-md-3">
                                                        <h5 class="fw-bold text-end fs-4 mt-3">USD
                                                            {{ number_format($cart->offer_price, 2) }}
                                                        </h5>
                                                         @if (isset($cart->shippingData[0]['shipping_partner']))
                                                            <p class="text-muted text-end mt-2 "
                                                                style="font-size: 13px;">
                                                                {{ $cart->shippingData[0]['shipping_partner'] }}
                                                                {{ $cart->shippingData[0]['shipping_method'] }}</p>
                                                        @endif
                                                        <div class="price_info text-end mt-3">
                                                            @if ($seller_shipping_cost > 0)
                                                                <p class="my-2">Shipping Cost: +
                                                                    <span
                                                                        class="text-danger">{{ number_format($seller_shipping_cost, 2) }}</span>
                                                                </p>
                                                            @elseif($seller_shipping_cost == 0)
                                                                <p class="my-2">Free Shipping</p>
                                                            @else
                                                                <p class="my-2">No Shipping</p>
                                                            @endif
                                                            
                                                        </div>
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

                                        <div class="d-flex justify-content-between mt-4">
                                            <strong class="fw-bold">Shipment</strong> <strong class="fw-bold">USD
                                                {{ number_format($totalShippingCost, 2) }}</strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between mt-3">
                                            <strong class="fw-bold">Total</strong> <strong class="fw-bold">USD
                                                {{ number_format($totalShippingCost + $totalPrice, 2) }}</strong>
                                        </div>
                                        <div class="mt-5 mb-3">
                                            <a href="{{ route('checkout.tender', $vendorRef) }}"
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
