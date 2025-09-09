@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">New State Of Tenders</h6>
                <div class="card rounded-0 px-2 px-md-4">
                    <div class="card-body ">
                        <div class="row my-3 justify-content-start">
                            <div class="col-md-12">

                                <ul class="d-flex flex-wrap justify-content-between align-items-center "  style="list-style: disc !important;">
                                    <h6 class="text-secondary fs-5 fw-bold me-md-5 me-4 mb-0 pb-0 ">Suppliers Tender Activities:</h6>
                                    <li class="me-md-5 me-4" style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline d-block  position-relative"
                                            href="{{ route('buyer.offered.tender') }}">
                                            My Submitted Offers ({{ $myRSubmittedOfferTender }})
                                            <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$mySubmittedOfferTender ?? 0}}</span>
                                        </a>
                                    </li>
                                    <li class="me-md-5 me-4" style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline d-block position-relative"
                                            href="{{ route('buyer.counter.offer.tender') }}">
                                            Received Counter Offers ({{ $myRReceivedCounterOfferTender }})
                                            <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$myReceivedCounterOfferTender ?? 0}}</span>
                                        </a>
                                    </li>
                                    <li class="me-md-5 me-4" style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline d-block position-relative" href="{{route('buyer.deal.offer.tender')}}">
                                            My Tender Deals ({{ $myRDealedOfferTender }})
                                            <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$myDealedOfferTender ?? 0}}</span>
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
