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
                        <li class="breadcrumb-item"><a class="text-primary" href="{{ url()->previous() }}">Back</a></li>
                        <li class="breadcrumb-item"><a class="text-primary" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Checkout
                        </li>
                    </ol>
                </nav>
                @if ($carts)
                    @php
                        $totalShippingCost = 0;
                        $totalPrice = 0;
                        $itemNumbers='';
                    @endphp
                    @foreach ($carts as $cart)
                         
                        @php
                            if(isset($cart->product->id)){
                                $itemNumbers .= str_pad($cart->product->id, 9, '0', STR_PAD_LEFT).' ';
                            }
                            $totalPrice += $cart->price;
                            if (isset($cart->yourShippingCost['country'])) {
                                $totalShippingCost += $cart->yourShippingCost['shipping_cost'];
                            }
                        @endphp
                    @endforeach
                @endif
                <form method="post" enctype="multipart/form-data" action="{{ route('order.now.product') }}"
                    class="row mt-5">
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
                                            @if ($bankDetails->isPayPal)
                                                <tr>
                                                    <td>
                                                        <div class="py-3 d-flex align-items-center gap-2">
                                                            <input type="radio" name="payment" id="paypal"
                                                                value="paypal"
                                                                data-detail="Pay using PayPal. Email: {{ $bankDetails->email }}"
                                                                onchange="showDetails(this)">
                                                            <img style="height:1.5rem;"
                                                                src="{{ asset('uploads/logo/paypal.png') }}" alt="PayPal"
                                                                class="payment-logo">
                                                            <label for="paypal" class="mb-0 pb-0">PayPal</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($bankDetails->isGooglePay)
                                                <tr>
                                                    <td>
                                                        <div class="py-3 d-flex align-items-center gap-2">
                                                            <input type="radio" name="payment" id="gpay"
                                                                value="gpay"
                                                                data-detail="Pay using Google Pay. UPI: {{ $bankDetails->upi_google }}"
                                                                onchange="showDetails(this)">
                                                            <img style="height:1.7rem;"
                                                                src="{{ asset('uploads/logo/gpay.png') }}" alt="Google Pay"
                                                                class="payment-logo">
                                                            <label for="gpay">Google Pay</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($bankDetails->isOther)
                                                <tr>
                                                    <td>
                                                        <div class="py-3 d-flex align-items-center gap-2">
                                                            <input type="radio" name="payment" id="other"
                                                                value="other"
                                                                data-detail="Pay using {{ $bankDetails->other_method_name }}. <br> Details: {{ $bankDetails->other_value }}"
                                                                onchange="showDetails(this)">
                                                            <img style="height:3.7rem;"
                                                                src="{{ asset('apple-pay.png') }}" alt="Other"
                                                                class="payment-logo">
                                                            <label
                                                                for="other">{{ $bankDetails->other_method_name }}</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($bankDetails->isBankDetail)
                                                <tr>
                                                    <td>
                                                        <div class="py-3 d-flex align-items-center gap-2">
                                                            <input type="radio" name="payment" id="instant_transfer"
                                                                value="instant_transfer"
                                                                data-detail="Pay via Instant Transfer. <br> Account Holder: {{ $bankDetails->account_holder }} <br> Bank: {{ $bankDetails->bank_name }} <br> IBAN: {{ $bankDetails->iban }}<br> BIC: {{ $bankDetails->bic }}"
                                                                onchange="showDetails(this)">
                                                            <img style="height:1.7rem;"
                                                                src="{{ asset('uploads/logo/bank.png') }}" alt="Bank"
                                                                class="payment-logo">
                                                            <label for="instant_transfer">Instant Transfer</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                            <input type="hidden" name="vendor_id" value="{{ $bankDetails->vendor_id ?? '' }}">
                                        </tbody>
                                    </table>
                                </div>

                                <div id="payment-details" class="mt-4" style="display:none;">
                                    <h5 class="text-primary fs-5">Payment Method Details</h5>
                                    <p id="payment-info" class="fw-bold text-dark"></p>
                                    <h5 class="fw-bold mt-2">Payment Subject</h5>
                                    <p>
                                        <span class="text-bold">
                                            WBG Item Number: 
                                        </span>
                                         {{ $itemNumbers }}
                                    </p>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="card rounded-0  border-1 mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <strong class="fw-bold">Article ({{ count($carts) }})</strong> <strong
                                        class="fw-bold">USD
                                        {{ number_format($totalPrice, 2) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <strong class="fw-bold">Shipment</strong> <strong class="fw-bold">USD
                                        {{ number_format($totalShippingCost, 2) }}</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-3">
                                    <strong class="fw-bold">Total</strong> <strong class="fw-bold">USD
                                        {{ number_format($totalPrice + $totalShippingCost, 2) }}</strong>
                                </div>
                              
                                <div class="mt-5 mb-3">
                                    <button id="payBtn" class="btn btn-primary w-100 disabled-btn" disabled>Order
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

                                <p class="d-block my-2">{{ $user->first_name . ' ' . $user->last_name }}</p>
                                <p class="d-block mb-2">{{ $myAddress['house_no'] . ' ' . $myAddress['street'] }}</p>
                                <p class="d-block mb-2">{{ $myAddress['postal_code'] }}, {{ $myAddress['city'] }}</p>
                                <p class="d-block mb-2">{{ $myAddress['state_name'] . ', ' . $myAddress['country_name'] }}
                                </p>
                                <p class="d-block mb-2">Phone: {{ $myAddress['phone_number'] }}</p>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </section>
    @include('external-user.inc-parts.listCard')
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
    <script>
        function showDetails(radio) {
            const details = radio.dataset.detail;
            document.getElementById('payment-details').style.display = 'block';
            document.getElementById('payment-info').innerHTML = details;
            document.getElementById('selected_payment_method').value = radio.value;
        }
    </script>
@endsection
