@extends('external-user.external-frame')

@section('meta_data')
    <title>Get Quote across the Globe on World Business Guide – WBG24.com</title>
    <meta name="description"
        content="Use Request for Quotation (RFQ) for individual Results & best Price Business Deals on World Business Guide – WBG24.com – Your international Market.">
    <meta name="keywords" content="Get Quote, Request for Quotation, RFQ, Business Deals">
    <meta name="author" content="WBG24.com">
@endsection

@section('external-main-content')
    <section class="container my-4">
        <div class="row">
            <div class="col-12 mb-4 d-flex align-items-center">
                <div style="height: 3rem; width: 3rem">
                    <img src="{{ asset('uploads/icons/icon1.png') }}" style="height: 100%; width: 100%" alt="" />
                </div>

                <div class="px-3">
                    <h6 class="fw-bolder text-primary pb-0 mb-0">
                        Request for Quotations
                    </h6>
                    <small class="text-muted pt-0 mt-0">One Request, Multiple Quotes</small>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-12 mb-4 bg-primary d-flex justify-content-center align-items-center py-4">
                        <h6 class="text-white fs-5 fw-semibold mb-0 pb-0">Benefits for Buyers</h6>
                    </div>
                    <div class="col-md-4">
                        <div class="card rounded-0 shadow " style="background-color: #e6e6e6">
                            <div class="card-body d-flex justify-content-center flex-column align-items-center">
                                <div class="bg-info rounded-circle text-white d-flex justify-content-center align-items-center fs-3 fw-bolder"
                                    style="height: 4rem; width: 4rem">
                                    #1
                                </div>
                                <div class="py-3 text-center">
                                    <h5>TELL US WHAT YOU NEED</h5>
                                    <p>
                                        Complete simple form and let us know about your
                                        requirement.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow rounded-0 " style="background-color: #e6e6e6">
                            <div class="card-body d-flex justify-content-center flex-column align-items-center">
                                <div class="bg-info rounded-circle text-white d-flex justify-content-center align-items-center fs-3 fw-bolder"
                                    style="height: 4rem; width: 4rem">
                                    #2
                                </div>
                                <div class="py-3 text-center">
                                    <h5>RECEIVE QUOTES</h5>
                                    <p>
                                        You receive customized price quotes from qualified
                                        suppliers.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow rounded-0 " style="background-color: #e6e6e6">
                            <div class="card-body d-flex justify-content-center flex-column align-items-center">
                                <div class="bg-info rounded-circle text-white d-flex justify-content-center align-items-center fs-3 fw-bolder"
                                    style="height: 4rem; width: 4rem">
                                    #3
                                </div>
                                <div class="py-3 text-center">
                                    <h5>CHOOSE BEST SUPPLIER & TRADE</h5>
                                    <p>
                                        Compare quotes and choose best supplier's. Its quick and
                                        easy
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <div class="card shadow rounded-0 " style="background-color: #e6e6e6">
                            <div class="card-body d-flex align-items-center">
                                <i class="fa fa-clock fs-5 text-danger me-3"></i> Save time in
                                search of <br> supplier
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="card shadow rounded-0 " style="background-color: #e6e6e6">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-users fs-5 text-danger me-3"></i> Responses
                                directly from Verified suppliers
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="card shadow rounded-0 " style="background-color: #e6e6e6">
                            <div class="card-body d-flex align-items-center">
                                <i class="fas fa-envelope-open fs-5 text-danger me-3"></i>
                                Compare & Evakute the <br> quotes
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5 text-center">
    @guest
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#loginPromptModal">
            Start your Request for Quotation
        </button>
    @endguest

    @auth
        <a class="btn btn-secondary" href="{{ route('user.get.quotes') }}">
            Start your Request for Quotation
        </a>
    @endauth
</div>

<!-- Modal -->
<div class="modal fade" id="loginPromptModal" tabindex="-1" aria-labelledby="loginPromptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You need to be logged in to request a quotation.
            </div>
            <div class="modal-footer">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </section>
@endsection
