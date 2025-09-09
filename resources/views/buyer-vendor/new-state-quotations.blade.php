@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">New State Of Quotations</h6>
                <div class="card rounded-0 px-2 px-md-4">
                    <div class="card-body ">
                        <div class="row my-3 justify-content-start">
                            <div class="col-md-12">
                                <ul class="d-flex flex-wrap justify-content-between align-items-center " style="list-style: disc !important;">
                                    <h6 class="text-secondary fs-5 fw-bold me-md-5 me-4 mb-0 pb-0 ">My Quotation Activities:</h6>
                                    <li class="me-md-5 me-4" style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline  d-block mt-3"
                                            href="{{ route('buyer.myquotations.show') }}">
                                            My listed Quotations ({{ $quotation }})
                                        </a>
                                    </li>
                                    <li class="me-md-5 me-4" style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline d-block  mt-3 position-relative"
                                            href="{{ route('buyer.myreceived.quotes.show') }}">
                                            My Received Quotes ({{ $myRReceivedOfferQuotation }})
                                            <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$myReceivedOfferQuotation ?? 0}}</span>
                                        </a>
                                    </li>
                                    <li class="me-md-5 me-4" style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline d-block  mt-3 position-relative"
                                            href="{{ route('buyer.counter.quotes.show') }}">
                                            My Counter Quotes ({{ $myRSubmittedCounterOfferQuotation }})
                                         <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$mySubmittedCounterOfferQuotation ?? 0}}</span>
                                        </a>
                                    </li>
                                    <li class="me-md-5 me-4" style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline d-block  mt-3 position-relative"
                                            href="{{ route('buyer.quote-deal') }}">
                                            My Quotation Deals ({{ $myROfferQuotationDeal }})
                                          <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$myOfferQuotationDeal ?? 0}}</span>
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
