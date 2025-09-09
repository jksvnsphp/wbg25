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
    <!-- Buyer Products Section -->
    <section class="container my-4">
        <div class="row">
            <div class="col-md-12 py-4 pt-5">
                <h3 class="fs-2 fw-bolder text-primary">
                    Buyer Products Help
                </h3>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-4">
                <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                    <a class="navbar-brand fs-4 fw-bolder text-primary" href="#">Buyer Help Articles</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link text-primary" href="#howToBuy">How to buy Products</a>
                        <a class="nav-link text-primary" href="#howToPay">How to pay my purchased Product</a>
                        <a class="nav-link text-primary" href="#viewPurchased">How to view my purchased Products</a>
                        <a class="nav-link text-primary" href="#trackOrder">How to Track my Order</a>
                    </nav>
                </nav>
            </div>
            <div class="col-lg-8">
                <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                    <!-- How to buy Products -->
                    <section id="howToBuy">
                        <h4 class="fw-bolder text-primary">How to buy Products?</h4>
                        <p class="linehight">
                            Before you can start to buy on WBG24.com, you need a Buyer or Seller Account.
                        </p>
                        <p class="linehight">
                            Once you've found the right Product, click on <span class="text-primary">"Buy now"</span> or on <span class="text-primary">"Add to Cart"</span> and proceed to Checkout.
                        </p>
                        <p class="linehight">
                            Double-Check your Order Summary before making the Payment. After placing the Order, you will receive a Confirmation Email with the Details of your Purchase.
                        </p>
                    </section>
                    <hr>

                    <!-- How to pay my purchased Product -->
                    <section id="howToPay">
                        <h4 class="fw-bolder text-primary">How to pay my purchased Product?</h4>
                        <p class="linehight">
                            Just click on the <span class="text-primary">"Shopping Cart"</span> Symbol, choose the Product you want to pay and click on <span class="text-primary">"Checkout"</span>.
                        </p>
                        <p class="linehight">
                            Then you will forwarded to choose a Seller accepted Payment Method.
                        </p>
                        <p class="linehight">
                            Select the Payment Method which you want to use and click on <span class="text-primary">"Order now"</span>, then you will finally forwarded, to Transfer the Payment as choosed.
                        </p>
                    </section>
                    <hr>

                    <!-- How to view my purchased Products -->
                    <section id="viewPurchased">
                        <h4 class="fw-bolder text-primary">How to view my purchased Products?</h4>
                        <p class="linehight">
                            Sign in - Dashboard Menu Bar – Click on <span class="text-primary">"Purchased Products"</span>
                        </p>
                        <p class="linehight">
                            Here you find a Overview of your purchased Products.
                        </p>
                        <p class="linehight">
                            If you click on the <span class="text-primary">"Details"</span> Button on listed purchased Product, then you will forwarded to the <span class="text-primary">"My purchased Product Details"</span> Site.
                        </p>
                        <p class="linehight">
                            Now you see the Shipping Adress and the Payment & Shipment Status for the purchased Product.
                        </p>
                        <p class="linehight">
                            After you have pay the total Product Amount, you need to mark the Payment Status to <span class="text-primary">"paid"</span>.
                        </p>
                        <p class="linehight">
                            Then the Seller will shipped the purchased Product in the setted handling Time out.
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
                            After the Seller have send the purchased Products out, the Seller will mark on the <span class="text-primary">"My purchased Product Details"</span> Site the Shipment Status to <span class="text-primary">"shipped"</span> and will leave the Shipping Company Name and the Order Tracking Number.
                        </p>
                        <p class="linehight">
                            Thats how you can track the Order Status of your purchased Product.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection