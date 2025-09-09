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
    <!-- Buyer Quotations Section -->
    <section class="container my-4">
        <div class="row">
            <div class="col-md-12 py-4 pt-5">
                <h3 class="fs-2 fw-bolder text-primary">
                    Buyer Quotations Help
                </h3>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                    <a class="navbar-brand fs-4 fw-bolder text-primary" href="#">Quotation Help Articles</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-primary" href="#howToGetQuote">How to get Quote</a>
                        <a class="nav-link text-primary" href="#viewListed">How to view my listed Quotations</a>
                        <a class="nav-link text-primary" href="#howToPay">How to pay my Quotation Deal</a>
                        <a class="nav-link text-primary" href="#viewDeals">How to view my Quotation Deal</a>
                        <a class="nav-link text-primary" href="#trackOrder">How to Track my Order</a>
                    </nav>
                </nav>
            </div>
            <div class="col-lg-8">
                <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                    <!-- How to get Quote -->
                    <section id="howToGetQuote">
                        <h4 class="fw-bolder text-primary">How to get Quote?</h4>
                        
                        <p class="linehight">
                            Sign in – Dashboard Menu Bar – Quotations & Management – Select <span class="text-primary">"Add new Request"</span>
                        </p>
                        <p class="linehight">
                            Fulfill out the Form and click on <span class="text-primary">"Get Quotation now"</span>
                        </p>
                    </section>
                    <hr>

                    <!-- How to view my listed Quotations -->
                    <section id="viewListed">
                        <h4 class="fw-bolder text-primary">How to view my listed Quotations?</h4>
                        <iframe style="width:100%;height:14rem;"  src="https://www.youtube.com/embed/go6kyTjl8l0?si=txINV2jUEEjpTBc4" title="YouTube video player" frameborder="1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        <p class="linehight">
                            Sign in – Dashboard Menu Bar – Quotations & Management – Select <span class="text-primary">"My listed Quotations"</span>
                        </p>
                        <p class="linehight">
                            Here you can see active or inactive listed Quotations.
                        </p>
                        <p class="linehight">
                            If you didn't get the wished success with your Request in the published Time, than you can re-list your Request after the Status is set to inactive.
                        </p>
                    </section>
                    <hr>

                    <!-- How to pay my Quotation Deal -->
                    <section id="howToPay">
                        <h4 class="fw-bolder text-primary">How to pay my Quotation Deal?</h4>
                        <p class="linehight">
                            Just click on the <span class="text-primary">"Shopping Cart"</span> Symbol, choose the Quotation Deal you want to pay and click on <span class="text-primary">"Checkout"</span>.
                        </p>
                        <p class="linehight">
                            Then you will forwarded to choose a Seller accepted Payment Method.
                        </p>
                        <p class="linehight">
                            Select the Payment Method which you want to use and click on <span class="text-primary">"Order now"</span>, then you will finally forwarded, to Transfer the Payment as choosed.
                        </p>
                    </section>
                    <hr>

                    <!-- How to view my Quotation Deal -->
                    <section id="viewDeals">
                        <h4 class="fw-bolder text-primary">How to view my Quotation Deal?</h4>
                        <p class="linehight">
                            Sign in - Dashboard - New State – Quotations - Click on <span class="text-primary">"More Info"</span>
                        </p>
                        <p class="linehight">
                            Then you will forwarded to the <span class="text-primary">"New State of Quotations"</span>, click on <span class="text-primary">"My Quotation Deals"</span>
                        </p>
                        <p class="linehight">
                            Here you find a Overview of your Quotation Deals.
                        </p>
                        <p class="linehight">
                            If you click on the <span class="text-primary">"Details"</span> Button on listed Quotation Deal, then you will forwarded to the <span class="text-primary">"My Quotation Deals Details"</span> Site.
                        </p>
                        <p class="linehight">
                            Now you see the Shipping Address and the Payment & Shipment Status for the Quotation Deal.
                        </p>
                        <p class="linehight">
                            After you have pay the total Quotation Amount, you need to mark the Payment Status to <span class="text-primary">"paid"</span>.
                        </p>
                        <p class="linehight">
                            Then the Seller will shipped the purchased Quotation Article/Service in the setted handling Time out.
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
                            After the Seller have send the purchased Quotation Article/Service out, the Seller will mark on the <span class="text-primary">"My Quotation Deals Details"</span> Site the Shipment Status to <span class="text-primary">"shipped"</span> and will leave the Shipping Company Name and the Order Tracking Number.
                        </p>
                        <p class="linehight">
                            With this Datas you can track the Order Status of your Quotation Deal.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection