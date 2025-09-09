@extends('external-user.external-frame')

@section('external-main-content')
    <style>
        .card-header img {
            object-fit: cover;
            width: 12rem;
            height: auto;
        }
        .card-title {
            font-size: 1.8rem;
            font-weight: bolder;
            margin: 1rem 0;
            color: #28a745;
            text-align: center;

        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
            margin: 1rem 0;
        }

        .order-number {
            font-weight: bold;
            color: #343a40;
            font-size: 1.1rem;
        }
    </style>
    <section class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card my-3 mt-4 shadow border-0">
                    
                    <div class="card-body text-center">
                        <img src="{{ asset('uploads/success.gif') }}" alt="Order Success GIF">
                        <h5 class="card-title">Order Placed Successfully!</h5>
                        <p class="card-text">
                            Thank you for your purchase! Your order number is <span
                                class="order-number">{{ session('order_number') }}</span>.
                        </p>
                        <p class="card-text">We’re processing your order and will notify you when it’s on the way.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('external-user.inc-parts.listCard')
@endsection
