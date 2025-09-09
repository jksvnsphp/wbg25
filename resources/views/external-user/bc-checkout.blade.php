@extends('external-user.external-frame')

@section('external-main-content')
    <style>
        .disabled-btn {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
    <section class="container-fluid">
        <div class="row">

            <div class="col-md-12 mb-4">
                <!-- Products -->
                <nav aria-label="breadcrumb" class="mb-2 mt-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Back</a></li>
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Checkout
                        </li>
                    </ol>
                </nav>
                @if ($carts)
                    @php
                        $totalShippingCost = 0;
                        $totalPrice = 0;
                    @endphp
                    @foreach ($carts as $cart)
                        @php
                            $totalPrice += $cart->price;
                            if (isset($cart->yourShippingCost['country'])) {
                                $totalShippingCost += $cart->yourShippingCost['shipping_cost'];
                            }
                        @endphp
                    @endforeach
                @endif
                <form method="post" enctype="multipart/form-data" action="{{ route('order.now.product') }}" class="row mt-5">
                    @csrf
                    <div class="col-md-9 mb-3">
                        <div class="card border-0 mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">
                                                    <h4 class="fw-bold fs-4">Pay with</h4>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="py-3 d-flex align-items-center gap-2">
                                                        <input type="radio" name="payment" id="paypal" value="paypal">

                                                        <img for="paypal" style=" height:1.5rem;"
                                                            src="{{ asset('uploads/logo/paypal.png') }}" alt="PayPal"
                                                            class="payment-logo">
                                                        <label for="paypal" class="mb-0 pb-0">
                                                            PayPal
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-3 align-items-center gap-2">
                                                        <input type="radio" name="payment" id="credit_card"
                                                            value="credit_card">
                                                        <img style=" height:2rem;"
                                                            src="{{ asset('uploads/logo/credit_card.png') }}"
                                                            alt="Credit Card" class="payment-logo">
                                                        <label for="credit_card">Credit Card</label>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="py-3 d-flex align-items-center gap-2">
                                                        <input type="radio" name="payment" id="gpay" value="gpay">
                                                        <img style=" height:1.7rem;"
                                                            src="{{ asset('uploads/logo/gpay.png') }}" alt="gpay"
                                                            class="payment-logo">
                                                        <label for="gpay">Google Pay</label>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-3 align-items-center gap-2">
                                                        <input type="radio" name="payment" id="apple_pay"
                                                            value="apple_pay">
                                                        <img style=" height:1.7rem;"
                                                            src="{{ asset('uploads/logo/apple_pay.png') }}" alt="apple_pay"
                                                            class="payment-logo">
                                                        <label for="apple_pay">Apple Pay</label>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex py-3 align-items-center gap-2">
                                                        <input type="radio" name="payment" id="instant_transfer"
                                                            value="instant_transfer">
                                                        <img style=" height:1.7rem;"
                                                            src="{{ asset('uploads/logo/bank.png') }}"
                                                            alt="instant_transfer" class="payment-logo">
                                                        <label for="instant_transfer">Instant Transfer</label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="card rounded-0  border-1 mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <strong class="fw-bold">Article ({{ count($carts) }})</strong> <strong class="fw-bold">USD
                                        {{ number_format($totalPrice,2) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <strong class="fw-bold">Shipment</strong> <strong class="fw-bold">USD {{ number_format($totalShippingCost,2) }}</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-3">
                                    <strong class="fw-bold">Total</strong> <strong class="fw-bold">USD {{ number_format(($totalPrice+$totalShippingCost),2) }}</strong>
                                </div>
                                <div class="mt-5 mb-3">
                                    <button id="payBtn" class="btn btn-primary w-100 disabled-btn" disabled>Pay
                                        now</button>
                                    <small class="text-center d-block mt-2">Select Payment Method</small>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="address" value="{{ json_encode($myAddress) }}">
                        <input type="hidden" name="billing_address" value="{{ json_encode($billingAddress) }}">
                        <div class="card rounded-0 border-1 mt-3">
                            <div class="card-body">
                                <h5 class="fw-bold">Delivery Address</h5>
                                
                                <p class="d-block my-2">{{ $user->first_name.' '.$user->last_name }}</p>
                                <p class="d-block mb-2">{{ $myAddress['house_no'].' '.$myAddress['street'] }}</p>
                                <p class="d-block mb-2">{{ $myAddress['postal_code'] }}, {{ $myAddress['city'] }}</p>
                                <p class="d-block mb-2">{{ $myAddress['state_name'].', '.$myAddress['country_name']  }}</p>
                                <p class="d-block mb-2">Phone: {{ $myAddress['phone_number'] }}</p>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </section>
    <section class="w-100 my-4 mb-0">
        <div class="container-fluid">
            <div class="card rounded-0 bg-primary py-2">
                <h5 class="fw-bold fs-5 text-light text-center py-3 pb-3">
                    Do you have something to sell ?
                </h5>
                <div class="card-body">
                    <p class="text-light text-center">
                        Post your AD for free on World Business Guide - www.wbg24.com -
                        Your International Market
                    </p>
                    <div class="text-center mt-4">
                        <a href="{{ route('user.member.package') }}" class="btn btn-secondary">
                            Post Now
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('custom-js-external')
    <script>
        const payBtn = document.getElementById('payBtn');
        const paymentRadios = document.querySelectorAll('input[name="payment"]');

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    payBtn.disabled = false;
                    payBtn.classList.remove('disabled-btn');
                }
            });
        });
    </script>
@endsection
