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
    <!-- Buyer Tenders Section -->
    <section class="container my-4">
        <div class="row">
            <div class="col-md-12 py-4 pt-5">
                <h3 class="fs-2 fw-bolder text-primary">
                    Buyer Tenders Help
                </h3>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                    <a class="navbar-brand fs-4 fw-bolder text-primary" href="#">Tender Help Articles</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-primary" href="#howToBuy">How to buy on Tenders</a>
                        <a class="nav-link text-primary" href="#howToBid">How to bid on Tenders</a>
                        <a class="nav-link text-primary" href="#howToPay">How to pay my Tender Deal</a>
                        <a class="nav-link text-primary" href="#viewDeals">How to view my Tender Deal</a>
                        <a class="nav-link text-primary" href="#trackOrder">How to Track my Order</a>
                    </nav>
                </nav>
            </div>
            <div class="col-lg-8">
                <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                    <!-- How to buy on Tenders -->
                    <section id="howToBuy">
                        <h4 class="fw-bolder text-primary">How to buy on Tenders?</h4>
                        <p class="linehight">
                            Before you can start to buy on WBG24.com, you need a Buyer or Seller Account.
                        </p>
                        <p class="linehight">
                            Once you've found the right Tender, click on <span class="text-primary">"Accept Price and Deal"</span> and proceed to Checkout.
                        </p>
                        <p class="linehight">
                            Double-Check your Order Summary before making the Payment. After placing the Order, you will receive a Confirmation Email with the Details of your Purchase.
                        </p>
                    </section>
                    <hr>

                    <!-- How to bid on Tenders -->
                    <section id="howToBid">
                        <h4 class="fw-bolder text-primary">How to bid on Tenders?</h4>
                        <p class="linehight">
                            Before you can start to bid on WBG24.com, you need a Buyer or Seller Account.
                        </p>
                        <p class="linehight">
                            Once you've found the right Tender, click on <span class="text-primary">"Send Price Offer"</span>.
                        </p>
                        <p class="linehight">
                            Then the Buyer can accept your Price and give you the Deal, or the Seller will send you a <span class="text-primary">"Counter Offer"</span>.
                        </p>
                        <p class="linehight">
                            You can accept this Counter Offer to get a Deal. After a Tender Deal is complete, you will receive a Confirmation Email with the Details of your Tender Deal. Double-Check your Order Summary before making the Payment.
                        </p>
                        <p class="linehight">
                            Or you do not accept the Seller Counter Offer, then your Bid will cancel and the Communication of the Tender between Buyer & Seller will delete.
                        </p>
                        <p class="linehight">
                            You can find a Overview of all Tender Steps:
                        </p>
                        <ul class="linehight">
                            <li><span class="text-primary">"My Submitted Offers"</span></li>
                            <li><span class="text-primary">"Received Counter Offers"</span></li>
                            <li><span class="text-primary">"My Tender Deals"</span></li>
                        </ul>
                        <p class="linehight">
                            Dashboard – New State – Tenders – Click on <span class="text-primary">"More Info"</span>
                        </p>
                    </section>
                    <hr>

                    <!-- How to pay my Tender Deal -->
                    <section id="howToPay">
                        <h4 class="fw-bolder text-primary">How to pay my Tender Deal?</h4>
                        <p class="linehight">
                            Just click on the <span class="text-primary">"Shopping Cart"</span> Symbol, choose the Tender you want to pay and click on <span class="text-primary">"Checkout"</span>.
                        </p>
                        <p class="linehight">
                            Then you will forwarded to choose a Seller accepted Payment Method.
                        </p>
                        <p class="linehight">
                            Select the Payment Method which you want to use and click on <span class="text-primary">"Order now"</span>, then you will finally forwarded, to Transfer the Payment as choosed.
                        </p>
                    </section>
                    <hr>

                    <!-- How to view my Tender Deal -->
                    <section id="viewDeals">
                        <h4 class="fw-bolder text-primary">How to view my Tender Deal?</h4>
                        <p class="linehight">
                            Sign in - Dashboard - New State – Tenders - Click on <span class="text-primary">"More Info"</span>
                        </p>
                        <p class="linehight">
                            Then you will forwarded to the <span class="text-primary">"New State of Tenders"</span>, click on <span class="text-primary">"My Tender Deals"</span>
                        </p>
                        <p class="linehight">
                            Here you find a Overview of your Tender Deals.
                        </p>
                        <p class="linehight">
                            If you click on the <span class="text-primary">"Details"</span> Button on listed Tender Deal, then you will forwarded to the <span class="text-primary">"My Tender Deals Details"</span> Site.
                        </p>
                        <p class="linehight">
                            Now you see the Shipping Address and the Payment & Shipment Status for the Tender Deal.
                        </p>
                        <p class="linehight">
                            After you have pay the total Tender Amount, you need to mark the Payment Status to <span class="text-primary">"paid"</span>.
                        </p>
                        <p class="linehight">
                            Then the Seller will shipped the purchased Tender Article/Service in the setted handling Time out.
                        </p>
                        <p class="linehight">
                            If requested, you can Contact the Seller and send a Message.
                        </p>
                    </section>
                    <hr>

                    <!-- How to Track my Order -->
                    <section id="trackOrder">
                        <h4 class="fw-bolder text-primary">How to Track my Order?</h4>
                        <p class="linehight">
                            After the Seller have send the purchased Tender Article/Service out, the Seller will mark on the <span class="text-primary">"My Tender Deals Details"</span> Site the Shipment Status to <span class="text-primary">"shipped"</span> and will leave the Shipping Company Name and the Order Tracking Number.
                        </p>
                        <p class="linehight">
                            With this Datas you can track the Order Status of your Tender Deal.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection