@extends('seller-vendor.seller-frame')
@section('seller-main-content')
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-2 bg-primary py-3">
            <h6 class="fs-5 text-light py-3 px-3">New State Of Tenders</h6>
            <div class="card rounded-0 px-2 px-md-4">
                <div class="card-body ">
                    <div class="row my-3 justify-content-start">
                        <div class="col-md-3">
                            <h6 class="text-secondary fs-5 fw-bold me-4 mb-0 pb-0 ">My Tender Activities: </h6>
                        </div>
                        <div class="col-md-8">
                            <ul class="d-flex flex-wrap" style="list-style: disc !important;">
                                <li class="me-md-5 me-4" style="list-style: disc !important;">
                                    <a class="text-dark text-decoration-underline  d-block position-relative " href="{{route('seller.get.tender')}}">
                                         My listed Tender ({{ $listedRTender }})
                                        <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$listedTender ?? 0}}</span>
                                    </a>
                                </li>
                                <li class="me-md-5 me-4" style="list-style: disc !important;">
                                    <a class="text-dark text-decoration-underline d-block position-relative" href="{{route('seller.received.offer.tender')}}">
                                          My Received Offers ({{ $myRReceivedOfferTender }})
                                        <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$myReceivedOfferTender ?? 0}}</span>
                                    </a>
                                </li>
                                <li class="me-md-5 me-4" style="list-style: disc !important;">
                                    <a class="text-dark text-decoration-underline d-block  position-relative" href="{{route('seller.offer-counter.tender')}}">
                                        My Counter Offers ({{ $myRSubmittedCounterOfferTender }})
                                        <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$mySubmittedCounterOfferTender ?? 0}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-start">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('arrow-image.png') }}" alt="arrow-image" style="width: 100%;" />
                        </div>
                        <div class="col-md-3">
                            <ul class="d-flex flex-wrap" style="list-style: disc !important;">
                                <li class="me-md-5 me-3" style="list-style: disc !important;">
                                    <a class="text-dark text-decoration-underline d-block position-relative" href="{{route('seller.deal.offer.tender')}}">
                                     My Tender Deals ({{ $myRDealedOfferTender }})
                                        <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$myDealedOfferTender ?? 0}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-3 justify-content-start">
                        <div class="col-md-3">
                            <h6 class="text-secondary fs-5 fw-bold me-3 mb-0 pb-0 ">Suppliers Tender Activities:</h6>
                        </div>
                        <div class="col-md-8">
                            <ul class="d-flex flex-wrap" style="list-style: disc !important;">
                                <li class="me-md-5 me-4" style="list-style: disc !important;">
                                    <a class="text-dark text-decoration-underline d-block position-relative" href="{{route('seller.receive.offer-counter.tender')}}">
                                         My Submitted Offers ({{ $myRSubmittedOfferTender }})
                                        <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$myReceivedCounterOfferTender ?? 0}}</span>
                                    </a>
                                </li>
                                <li class="me-md-5 me-3" style="list-style: disc !important;">
                                    <a class="text-dark text-decoration-underline d-block position-relative" href="{{route('seller.offered.tender')}}">
                                        My Received Offers ({{ $myRReceivedOfferTender }})
                                        <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$mySubmittedOfferTender ?? 0}}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" onclick="window.history.back()" class="btn text-light">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
    </div>
</section>
@endsection