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
                    'seller.deal.offer.tender' => 'All Deals On Tender',
                    'seller.my-deal.offer.tender' => 'My Activity Deals',
                    'seller.supplier-deal.offer.tender' => 'Supplier Deals',
                    default => 'My Deals On Tender',
                    };
                    @endphp
                    {{$heading ?? 'All Deal On Tender'}}
                </h6>
                <a href="{{ route('seller.deal.offer.tender') }}" class="btn btn-sm me-3 {{ Route::currentRouteName() == 'seller.deal.offer.tender' ? 'btn-secondary disabled' : 'btn-light' }}">All Deals</a>
                <a href="{{ route('seller.my-deal.offer.tender') }}" class="btn btn-sm me-3 {{ Route::currentRouteName() == 'seller.my-deal.offer.tender' ? 'btn-secondary disabled' : 'btn-light' }}">My Tender Deals</a>
                <a href="{{ route('seller.supplier-deal.offer.tender') }}" class="btn btn-sm {{ Route::currentRouteName() == 'seller.supplier-deal.offer.tender' ? 'btn-secondary disabled' : 'btn-light' }}">Suplliers Tender Deals</a>
            </div>
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">

                            <thead>
                                <tr>
                                    <th scope="col">Tender</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Deal With</th>
                                    <th scope="col">Tender Price</th>
                                    <th scope="col">Offer Price</th>
                                    <th scope="col">Detail</th>
                                    <th scope="col">Deal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tenders as $quote)
                                @php
                                $tender = $quote->tender ?? [];
                                $vendor = $tender->vendor ?? [];
                                $sender = $quote->sender ?? [];
                                @endphp
                                <tr id="row-{{ $quote->id }}">
                                    <td>
                                        <a href="{{ route('show.tender', $tender->slug) }}"
                                            style="width: 4rem !important; height:4rem !important;">
                                            <img src="{{ asset('uploads/tender/' . $tender->image_1) }}"
                                                class="w-100 h-100 rounded-2" alt=""
                                                style="width: 4rem !important; height:4rem !important;">
                                        </a>
                                    </td>
                                    <td>
                                        {{ $tender->name }}
                                    </td>

                                    <td>
                                        @if ($quote->user_id == auth()->user()->id)
                                        {{ $vendor->first_name ?? '' }}
                                        {{ $vendor->last_name ?? '' }}
                                        @elseif ($quote->vendor_id == auth()->user()->id)
                                        {{ $sender->first_name ?? '' }}
                                        {{ $sender->last_name ?? '' }}
                                        @endif
                                    </td>
                                    <td>
                                        US$ {{ $tender->price }}
                                    </td>
                                    <td>
                                        US$ {{ $quote->offer_price }}
                                    </td>
                                    <td>
                                        @if (isset($quote->status) && $quote->status == 'accept')
                                        <a href="{{ route('seller.deal-detail.tender',[$quote->tender->slug,$quote->id]) }}"
                                            class="btn btn-sm btn-primary">Details</a>
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
                                                US$ {{ (!empty($quote->counter_price) && $quote->counter_price > 0) ? $quote->counter_price : $quote->offer_price }}
                                            </h6>
                                            @if ($quote->user_id == auth()->user()->id)
                                            <button
                                                data-name="{{ $vendor->first_name ?? '' }} {{ $vendor->last_name ?? '' }}"
                                                data-email="{{ $vendor->email ?? '' }}"
                                                data-phone="{{ $vendor->phone ?? '' }}"
                                                data-title="Seller Contact Info" type="button"
                                                class="btn btn-primary btn-sm contact-btn">
                                                Seller Contact
                                            </button>
                                            @elseif ($quote->vendor_id == auth()->user()->id)
                                            <button
                                                data-name="{{ $sender->first_name ?? '' }} {{ $sender->last_name ?? '' }}"
                                                data-email="{{ $sender->email ?? '' }}"
                                                data-phone="{{ $sender->phone ?? '' }}"
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