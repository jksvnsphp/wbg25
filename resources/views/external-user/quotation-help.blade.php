@extends('external-user.external-frame')

@section('external-main-content')
<!-- Header section end here -->
<style>
    .linehight {
        line-height: 1.5 !important;
    }

    .nav-link {
        color: #02368b !important;
    }

    .nav-pills .nav-link.active {
        background-color: #02368b !important;
        color: #fff !important;
    }

    .ulm li {
        list-style: unset !important;
        margin-left: 10px;
    }
</style>
<!-- Data Protection Section -->
<section class="container my-4">
    <div class="row">
        <div class="col-md-12 py-4 pt-5">
            <h3 class="fs-2 fw-bolder text-primary">
                Quotation Assistance
            </h3>
            <p class="text-primary mt-4" style="line-height: 1.5">
                Complete guide to managing your quotations, requests, and deals
            </p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4">
            <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                <a class="navbar-brand fs-5 fw-bolder text-primary" href="#">Quotation Help Articles</a>
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link text-primary" href="#listRequest">How to get Quote?</a>
                    <a class="nav-link text-primary" href="#receivedOffers">How to view received Quotes</a>
                    <a class="nav-link text-primary" href="#counterOffers">How to view Counter Quotes</a>
                    <a class="nav-link text-primary" href="#receivedCounters">How to view received Counters</a>
                    <a class="nav-link text-primary" href="#submittedOffers">How to view submitted Quotes</a>
                    <a class="nav-link text-primary" href="#quotationDeals">How to view Quotation Deals</a>
                </nav>
            </nav>
        </div>
        <div class="col-lg-8">
            <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                <!-- List Request -->
                <section id="listRequest">
                    <h4 class="fw-bolder text-primary">How to get Quote?</h4>

                    <ul class="ulm linehight">
                        <li>Sign in</li>
                        <li>Dashboard Menu Bar - Select "Quotation & Management"</li>
                        <li>Option "List Request"</li>
                    </ul>
                    <p class="linehight">
                        Enter Product / Service you want to buy.<br>
                        Enter Requirements in Detail & Estimated Quantity.<br>
                        Set Type, Duration Time & Category<br>
                        Upload Images if you have and list your Request with a click on:<br>
                        <span class="text-primary">"Get Quotation now"</span>
                    </p>
                </section>
                <hr>

                <!-- My Listed Requests -->
                <section id="myListedRequests">
                    <h4 class="fw-bolder text-primary">How to view my listed Requests?</h4>
                    <iframe style="width:100%;height:14rem;"
                        src="https://www.youtube.com/embed/go6kyTjl8l0?si=txINV2jUEEjpTBc4" title="YouTube video player"
                        frameborder="1"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <ul class="ulm linehight">
                        <li>Sign in</li>
                        <li>Dashboard Menu Bar - Select "Quotation & Management"</li>
                        <li>Option "My listed Requests"</li>
                    </ul>
                    <p class="linehight">
                        Here you can see active or inactive listed Quotations.<br>
                        If you didn't get the wished success with your Request in the published Time,
                        you can re-list your Request after the Status is set to inactive.
                    </p>
                </section>
                <hr>

                <!-- Received Offers -->
                <section id="receivedOffers">
                    <h4 class="fw-bolder text-primary">How to view my received Quotes?</h4>
                    <ul class="ulm linehight">
                        <li>Sign in</li>
                        <li>Dashboard – New State – Click on Quotations Box "More Info"</li>
                        <li>Then you will be forwarded to the New State of Quotations Page, select "My Received Offers"
                        </li>
                    </ul>
                    <p class="linehight">
                        Here you find an Overview of your received Quotation Quotes.<br>
                        You can accept the received Quote to get a direct Quotation Deal.<br>
                        Or you can send a Counter Quote, then the Supplier can accept or don't accept.<br><br>
                        If the Supplier accepts your Counter Quote, then the Quotation Deal is complete.<br>
                        If the Supplier doesn't accept your Counter Offer, then the Communication between
                        Supplier & Quotation Offerant will be removed, no Deal.
                    </p>
                </section>
                <hr>

                <!-- My Counter Offers -->
                <section id="counterOffers">
                    <h4 class="fw-bolder text-primary">How to view my Counter Quote?</h4>
                    <ul class="ulm linehight">
                        <li>Sign in</li>
                        <li>Dashboard – New State – Click on Quotations Box "More Info"</li>
                        <li>Then you will be forwarded to the New State of Quotations Page, select "My Counter Offers"
                        </li>
                    </ul>
                    <p class="linehight">
                        Here you find an Overview of your Counter Quotes.<br>
                        If you do not see your Counter Offers listed there, then look under "My Quotation Deals".<br>
                        If your Counter Offer is also not listed on "My Quotation Deals", then this means that
                        the Supplier has rejected your "Counter Offer" and the previous Communication between
                        Supplier and Quotation Offerant has been removed.
                    </p>
                </section>
                <hr>

                <!-- Received Counters -->
                <section id="receivedCounters">
                    <h4 class="fw-bolder text-primary">How to view my received Counters?</h4>
                    <ul class="ulm linehight">
                        <li>Sign in</li>
                        <li>Dashboard – New State – Click on Quotations Box "More Info"</li>
                        <li>Then you will be forwarded to the New State of Quotations Page, select "My Received
                            Counters"</li>
                    </ul>
                    <p class="linehight">
                        Here you find an Overview of your received Counters.<br>
                        You can accept the received Counter to get a direct Quotation Deal.<br>
                        Or you don't accept the received Counter, then the Communication between
                        Supplier & Quotation Offerant will be removed, no Deal.
                    </p>
                </section>
                <hr>

                <!-- Submitted Offers -->
                <section id="submittedOffers">
                    <h4 class="fw-bolder text-primary">How to view my submitted Quotes?</h4>
                    <ul class="ulm linehight">
                        <li>Sign in</li>
                        <li>Dashboard – New State – Click on Quotations Box "More Info"</li>
                        <li>Then you will be forwarded to the New State of Quotations Page, select "My Submitted Offers"
                        </li>
                    </ul>
                    <p class="linehight">
                        Here you find an Overview of your submitted Quotes.<br>
                        If you do not see your submitted Quote listed there, then look to "My Received Counters".<br>
                        If your submitted Quote is also not listed on "My Received Counters", then look
                        to "My Quotation Deals". If your submitted Quote is nowhere listed, then this means that
                        the Supplier has rejected your "Submitted Quote". This means, that the previous
                        Communication between you as Supplier and the "Quotation Offerant" has been removed.
                    </p>
                </section>
                <hr>

                <!-- Quotation Deals -->
                <section id="quotationDeals">
                    <h4 class="fw-bolder text-primary">How to view my Quotation Deals?</h4>
                    <ul class="ulm linehight">
                        <li>Sign in</li>
                        <li>Dashboard Menu Bar - Select "Quotations & Management"</li>
                        <li>Option "My Quotation Deals"</li>
                    </ul>
                    <p class="linehight">
                        Here you find an Overview of your Quotation Deals.<br>
                        If you click on the "Details" Button on listed Quotation Deals, then you will be forwarded to
                        the
                        "My Quotation Deals Details" Site. Now you see the Shipping Address and the
                        Payment & Shipment Status for the Quotation Deal.<br><br>
                        After the Buyer has paid the total Quotation Amount, the Buyer needs to mark the Payment Status
                        to "paid".
                        Then the Supplier will ship the purchased Quotation Article/Service in the set handling Time out
                        and leave the Shipping Company and Order Tracking Number.<br>
                        If requested, Buyer can Contact the Supplier and send a Message.
                    </p>
                </section>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid my-3">
    <a href="{{ url()->previous() }}" class="btn btn-primary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>
@endsection