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
    <!-- Tender Section -->
    <section class="container my-4">
        <div class="row">
            <div class="col-md-12 py-4 pt-5">
                <h3 class="fs-2 fw-bolder text-primary">
                    Tender Assistance
                </h3>
                <p class="text-primary mt-4" style="line-height: 1.5">
                    Complete guide to managing your tenders, offers, and deals
                </p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <nav id="tenderNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                    <a class="navbar-brand fs-5 fw-bolder text-primary" href="#">Tender Help Articles</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-primary" href="#listTender">List Tender</a>
                        <a class="nav-link text-primary" href="#myListedTenders">My Listed Tenders</a>
                        <a class="nav-link text-primary" href="#receivedOffers">Received Offers</a>
                        <a class="nav-link text-primary" href="#counterOffers">My Counter Offers</a>
                        <a class="nav-link text-primary" href="#receivedCounters">Received Counters</a>
                        <a class="nav-link text-primary" href="#submittedOffers">Submitted Offers</a>
                        <a class="nav-link text-primary" href="#tenderDeals">Tender Deals</a>
                    </nav>
                </nav>
            </div>
            <div class="col-lg-8">
                <div data-bs-spy="scroll" data-bs-target="#tenderNav" data-bs-offset="0" tabindex="0">
                    <!-- List Tender -->
                    <section id="listTender">
                        <h4 class="fw-bolder text-primary">How to list Tender?</h4>
                        <iframe style="width:100%;height:14rem;" class="mb-5" src="https://www.youtube.com/embed/o_14Fk1_YOw?si=AgviCM35NUfC6R-G" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        <ul class="ulm linehight">
                            <li>Sign in</li>
                            <li>Dashboard Menu Bar - Select "Tenders & Management"</li>
                            <li>Option "List Tender"</li>
                        </ul>
                        <p class="linehight">
                            Search first on the Tender Upload Form for a Category for your Tender Listing.<br>
                            Enter Tender Key, choose and select a Tender Category Suggestion and click on Use.<br>
                            Enter Tender Title and Price, set Condition and Duration Time.<br>
                            Enter Tender Description and upload Tender Images.<br>
                            Set Shipping Settings and enter Shipping Regions or Country.<br>
                            Set handling Time and click on:<br>
                            <span class="text-primary">"List Tender"</span>
                        </p>
                    </section>
                    <hr>

                    <!-- My Listed Tenders -->
                    <section id="myListedTenders">
                        <h4 class="fw-bolder text-primary">How to view my listed Tenders?</h4>
                        <ul class="ulm linehight">
                            <li>Sign in</li>
                            <li>Dashboard Menu Bar - Select "Tenders & Management"</li>
                            <li>Option "My listed Tenders"</li>
                        </ul>
                        <p class="linehight">
                            Here you find an Overview of your listed Tenders.<br>
                            You can also Change on all listed Tenders all individual Details with a click on Action "Edit Button".<br>
                            After Click on the "Edit Button" you will redirect to the individual Tender Upload Form, where you can change all Details.<br>
                            Just confirm on the End of the Form your changes with a click on:<br>
                            <span class="text-primary">"Save Changes"</span>
                        </p>
                    </section>
                    <hr>

                    <!-- Received Offers -->
                    <section id="receivedOffers">
                        <h4 class="fw-bolder text-primary">How to view my received Offers?</h4>
                        <ul class="ulm linehight">
                            <li>Sign in</li>
                            <li>Dashboard – New State – Click on Tenders Box "More Info"</li>
                            <li>Then you will be forwarded to the New State of Tenders Page, select "My Received Offers"</li>
                        </ul>
                        <p class="linehight">
                            Here you find an Overview of your received Tender Offers.<br>
                            You can accept the received Offers and close the Deal with a click on "Accept",<br>
                            or you can send a Counter Offer. Just enter Price and click on<br>
                            <span class="text-primary">"Send"</span>
                        </p>
                    </section>
                    <hr>

                    <!-- My Counter Offers -->
                    <section id="counterOffers">
                        <h4 class="fw-bolder text-primary">How to view my Counter Offers?</h4>
                        <ul class="ulm linehight">
                            <li>Sign in</li>
                            <li>Dashboard – New State – Click on Tenders Box "More Info"</li>
                            <li>Then you will be forwarded to the New State of Tenders Page, select "My Counter Offers"</li>
                        </ul>
                        <p class="linehight">
                            Here you find an Overview of your Counter Offers.<br>
                            If you do not see your Counter Offers listed there, then look to "My Tender Deals".<br>
                            If your Counter Offer is also not listed on "My Tender Deals", then this means that<br>
                            the Buyer has rejected your "Counter Offer" and the previous Communication between<br>
                            you as Supplier and the buyer has been removed.
                        </p>
                    </section>
                    <hr>

                    <!-- Received Counters -->
                    <section id="receivedCounters">
                        <h4 class="fw-bolder text-primary">How to view my received Counters?</h4>
                        <ul class="ulm linehight">
                            <li>Sign in</li>
                            <li>Dashboard – New State – Click on Tenders Box "More Info"</li>
                            <li>Then you will be forwarded to the New State of Tenders Page, select "My Received Counters"</li>
                        </ul>
                        <p class="linehight">
                            Here you find an Overview of your received Counters.<br>
                            You can accept the received Counter to get a direct Tender Deal.<br>
                            Or you don't accept the received Counter, then the Communication between<br>
                            you as Buyer & the Tender Supplier will be removed, no Deal.
                        </p>
                    </section>
                    <hr>

                    <!-- Submitted Offers -->
                    <section id="submittedOffers">
                        <h4 class="fw-bolder text-primary">How to view my submitted Offers?</h4>
                        <ul class="ulm linehight">
                            <li>Sign in</li>
                            <li>Dashboard – New State – Click on Tenders Box "More Info"</li>
                            <li>Then you will be forwarded to the New State of Tenders Page, select "My Submitted Offers"</li>
                        </ul>
                        <p class="linehight">
                            Here you find an Overview of your submitted Offers.<br>
                            If you do not see your submitted Offer listed there, then look to "My Received Counters".<br>
                            If your submitted Offer is also not listed on "My Received Counters", then look<br>
                            to "My Tender Deals". If your submitted Offer is nowhere listed, then this means that<br>
                            the Supplier has rejected your "Submitted Offer". This means, that the previous<br>
                            Communication between you as Buyer and the Tender Supplier has been removed.
                        </p>
                    </section>
                    <hr>

                    <!-- Tender Deals -->
                    <section id="tenderDeals">
                        <h4 class="fw-bolder text-primary">How to view my Tender Deals?</h4>
                        <ul class="ulm linehight">
                            <li>Sign in</li>
                            <li>Dashboard Menu Bar - Select "Tenders & Management"</li>
                            <li>Option "My Tender Deals"</li>
                        </ul>
                        <p class="linehight">
                            Here you find an Overview of your Tender Deals.<br>
                            If you click on the "Details" Button on listed Tender Deals, then you will be forwarded to the<br>
                            "My Tender Deals" Details Site. Now you see the Shipping Address and the<br>
                            Payment & Shipment Status for the Tender Deal.<br><br>
                            After the Buyer has paid the total Tender Amount, the Buyer needs to mark the Payment Status to "paid".<br>
                            Then the Supplier will ship the purchased Tender Article/Service in the set handling Time out<br>
                            and leave the Shipping Company and Order Tracking Number.<br>
                            If requested, Buyer can Contact the Supplier and send a Message.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection