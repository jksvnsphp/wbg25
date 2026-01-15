@extends('seller-vendor.seller-frame')

@section('seller-main-content')
<style>
    .table-img {
        height: 6rem !important;
        width: 5rem !important;
        display: flex;
        justify-content: center;
    }

    .table-img img {
        object-fit: fill !important;
        object-position: center center;
    }

    .add_sc {
        font-size: 13px !important;
        font-weight: 600 !important;
    }

    .form-input:focus {
        outline: none !important;
    }
</style>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-2 bg-primary py-3">
            <div class="d-flex align-items-center justify-content-start mb-3">
                <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">
                    @php
                    $heading = match(Route::currentRouteName()) {
                    'seller.quote-deal' => 'All Deal Quotes',
                    'seller.my-quote-deal' => 'Suppliers Quotation Deals',
                    'seller.supplier-quote-deal' => 'My Quotation Deals',
                    default => 'My Deal Quotes',
                    };
                    @endphp
                    {{$heading ?? 'All Deal Quotes'}}
                </h6>
                <a href="{{ route('seller.quote-deal') }}" class="btn btn-sm me-3 {{ Route::currentRouteName() == 'seller.quote-deal' ? 'btn-secondary disabled' : 'btn-light' }}">All Deals</a>
                <a href="{{ route('seller.my-quote-deal') }}" class="btn btn-sm me-3 {{ Route::currentRouteName() == 'seller.my-quote-deal' ? 'btn-secondary disabled' : 'btn-light' }}">Suppliers Quotation Deals</a>
                <a href="{{ route('seller.supplier-quote-deal') }}" class="btn btn-sm {{ Route::currentRouteName() == 'seller.supplier-quote-deal' ? 'btn-secondary disabled' : 'btn-light' }}">My Quotation Deals</a>
            </div>
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">

                            <thead>
                                <tr>
                                    <th scope="col">Quotation</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Deal With(Name)</th>
                                    <th scope="col">Quote</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Deal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotations as $quote)
                                @php
                                $quotation = $quote->quotation ?? [];
                                @endphp
                                <tr id="row-{{ $quote->id }}">
                                    <td>
                                        <a href="{{ route('user.source-pro.detail', $quotation->slug) }}"
                                            style="width: 4rem !important; height:4rem !important;">
                                            <img src="{{ asset('uploads/quotation/' . $quotation->image_1) }}"
                                                class="w-100 h-100 rounded-2" alt=""
                                                style="width: 4rem !important; height:4rem !important;">
                                        </a>
                                    </td>
                                    <td>
                                        {{ $quotation->product_service }}
                                    </td>

                                    <td>
                                        @if ($quote->user_id == auth()->user()->id)
                                        {{ $quotation->vendor->first_name ?? '' }}
                                        {{ $quotation->vendor->last_name ?? '' }}
                                        @elseif($quote->vendor_id == auth()->user()->id)
                                        {{ $quote->sender->first_name ?? '' }}
                                        {{ $quote->sender->last_name ?? '' }}
                                        @endif
                                    </td>
                                    <td>
                                        US$ {{ $quote->offer_price }}
                                    </td>
                                    <td>
                                        {{ $quotation->quantity }}
                                    </td>
                                    <td>
                                        @if (isset($quote->status) && $quote->status == 'accept')
                                        <a class="btn btn-sm btn-primary" href="{{ route('seller.offer.quote-deal',[$quote->quotation->slug,$quote->id]) }}">Details</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($quote->status) && $quote->status == 'accept')
                                        <div
                                            class="d-flex align-items-center justify-content-center flex-column">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('world-business/images/vendor-ico/businessdeal.jpg') }}"
                                                    style="height: 4rem;" alt="">
                                            </div>
                                            <h6>
                                                US$ {{ $quote->counter_price ?? 0 }}
                                            </h6>
                                            @if ($quote->user_id == auth()->user()->id)
                                            <button
                                                data-name="{{ $quotation->vendor->first_name ?? '' }} {{ $quotation->vendor->last_name ?? '' }}"
                                                data-email="{{ $quotation->vendor->email ?? '' }}"
                                                data-phone="{{ $quotation->vendor->phone ?? '' }}"
                                                data-title="Seller Contact Info" type="button"
                                                class="btn btn-primary btn-sm contact-btn">
                                                Seller Contact
                                            </button>
                                            @elseif($quote->vendor_id == auth()->user()->id)
                                            <button
                                                data-name="{{ $quote->sender->first_name ?? '' }} {{ $quote->sender->last_name ?? '' }}"
                                                data-email="{{ $quote->sender->email ?? '' }}"
                                                data-phone="{{ $quote->sender->phone ?? '' }}"
                                                data-title="Buyer Contact Info" type="button"
                                                class="btn btn-primary btn-sm contact-btn">
                                                Buyer Contact
                                            </button>
                                            @endif
                                        </div>
                                        @endif
                                    </td>


                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" onclick="window.history.back()" class="btn text-light"><i
                        class="fas fa-arrow-left "></i> Back</button>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Buyer Contact Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="buyerName"></span></p>
                <p><strong>Email:</strong> <span id="buyerEmail"></span></p>
                <p><strong>Phone:</strong> <span id="buyerPhone"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('seller-custome-js')
<script>
    $(document).ready(function() {
        $(".contact-btn").on("click", function() {
            let name = $(this).data("name");
            let email = $(this).data("email");
            let phone = $(this).data("phone");
            let title = $(this).data("title");

            $("#contactModalLabel").text(title);
            $("#buyerName").text(name);
            $("#buyerEmail").text(email);
            $("#buyerPhone").text(phone);

            $("#contactModal").modal("show");
        });
    });
</script>
@endsection