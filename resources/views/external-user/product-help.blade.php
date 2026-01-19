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
                Product Help
            </h3>
            <p class="text-primary mt-4" style="line-height: 1.5">
                We Offer you 2 different Types of Product Listing:
                <br>
                Multiply Product listing – to use this Option you need to be a Gold or Platinum Member.
                <br>
                The Multiply Product listing is without Duration Time on Basic of the available Quantity.
                <br>
                The Multiply Product listing is explained on the Help Article: „Spotlight Store“
            </p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4">
            <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                <a class="navbar-brand fs-4 fw-bolder text-primary" href="#">Product Help Articles</a>
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link text-primary" href="#listingTypes">Product Listing Types</a>
                    <a class="nav-link text-primary" href="#listProducts">How to list Products</a>
                    <a class="nav-link text-primary" href="#viewListed">How to view my listed Products</a>
                    <a class="nav-link text-primary" href="#viewSold">How to view my sold Products</a>
                    <a class="nav-link text-primary" href="#viewPurchased">How to view my purchased Products</a>
                </nav>
            </nav>
        </div>
        <div class="col-lg-8">
            <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                <!-- Product Listing Types -->
                <section id="listingTypes">
                    <h4 class="fw-bolder text-primary">Product Listing Types</h4>
                    <iframe style="width: 100%;height:15rem;" class="mb-5" src="https://www.youtube.com/embed/aKdFsrbbhSY?si=MfBtHOEAyNkPHA4A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <p class="linehight">
                        We offer you 2 different types of Product Listing:
                    </p>
                    <p class="linehight">
                        <strong>Multiply Product Listing</strong> – To use this option you need to be a Gold or Platinum
                        Member.
                        The Multiply Product listing is without duration time based on the available quantity.
                        The Multiply Product listing is explained in the Help Article: <em>“Spotlight Store”</em>.
                    </p>
                </section>
                <hr>

                <!-- How to list Products -->
                <section id="listProducts">
                    <h4 class="fw-bolder text-primary">How to list Products?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Products &amp;
                            Management"</span> - Option <span class="text-primary">"List Product"</span>
                    </p>
                    <p class="linehight">
                        Search first on the Product Upload Form for a Category for your Product Listing. Enter the
                        Product Name, choose and select a Product Category Suggestion and click on <span
                            class="text-primary">Use</span>.
                    </p>
                    <p class="linehight">
                        Set Condition and, if needed, Item Specifics. Upload Product Images and a Product Video (if
                        available). Then, enter the total Quantity, Item Title, and Item Description.
                    </p>
                    <p class="linehight">
                        If you want to offer different prices for different quantity purchases, you can set up to 3
                        options, for example:
                    </p>
                    <ul class="linehight">
                        <li>Case 1: Min QTY 1 – Max Qty 9 = USD $10.00</li>
                        <li>Case 2: Min QTY 10 – Max Qty 49 = USD $9.00</li>
                        <li>Case 3: Min QTY 50 – Max Qty 100 = USD $8.00</li>
                    </ul>
                    <p class="linehight">
                        If you want to offer a single price regardless of purchase quantity, select only the first
                        pricing field and leave the Min Qty and Max Qty fields empty.
                    </p>
                    <p class="linehight">
                        Select a desired Payment Currency for your Product and enter a single Item Price. Your product
                        will then be offered at a uniform price.
                    </p>
                    <p class="linehight">
                        Set additional show cases like: Limited Offers, Daily Deals, Bulk Buying, or Hot Products. Set
                        Duration Time and Shipping Settings, enter Shipping Regions or Country, set Handling Time and
                        Accepted Returns, and click on <span class="text-primary">"List &amp; Sell"</span>.
                    </p>
                </section>
                <hr>

                <!-- How to view my listed Products -->
                <section id="viewListed">
                    <h4 class="fw-bolder text-primary">How to view my listed Products?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Products &amp;
                            Management"</span> - Option <span class="text-primary">"My listed Products"</span>
                    </p>
                    <p class="linehight">
                        Here you will find an overview of your listed products. You can also change individual details
                        on any listed product by clicking on the <span class="text-primary">"Edit Button"</span>.
                        After clicking the edit button, you will be redirected to the individual Product Upload Form
                        where you can modify the details. Finally, confirm your changes by clicking on <span
                            class="text-primary">"Save Changes"</span>.
                    </p>
                </section>
                <hr>

                <!-- How to view my sold Products -->
                <section id="viewSold">
                    <h4 class="fw-bolder text-primary">How to view my sold Products?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Products &amp;
                            Management"</span> - Option <span class="text-primary">"My sold Products"</span>
                    </p>
                    <p class="linehight">
                        Here you will find an overview of your sold products. If you click on the <span
                            class="text-primary">"Details"</span> button on any sold product, you will be forwarded to
                        the <span class="text-primary">"My sold Product Details"</span> page.
                    </p>
                    <p class="linehight">
                        On that page, you will see the Shipping Address and the Payment &amp; Shipment Status for the
                        sold product. Once the buyer marks the Payment Status as <span
                            class="text-primary">"paid"</span> and you have received the payment, ship the product
                        within your set Handling Time.
                    </p>
                    <p class="linehight">
                        If needed, you can contact the buyer and send a message. After shipping, mark the Shipment
                        Status as <span class="text-primary">"shipped"</span> and provide the Shipping Company Name and
                        Package Tracking Number so that the buyer can track the shipment.
                    </p>
                </section>
                <hr>

                <!-- How to view my purchased Products -->
                <section id="viewPurchased">
                    <h4 class="fw-bolder text-primary">How to view my purchased Products?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Products &amp;
                            Management"</span> - Option <span class="text-primary">"My purchased Products"</span>
                    </p>
                    <p class="linehight">
                        Here you will find an overview of your purchased products. If you click on the <span
                            class="text-primary">"Details"</span> button on a purchased product, you will be forwarded
                        to the <span class="text-primary">"My purchased Product Details"</span> page.
                    </p>
                    <p class="linehight">
                        On that page, you will see the Shipping Address and the Payment &amp; Shipment Status for the
                        purchased product. After you pay the total product amount, mark the Payment Status as <span
                            class="text-primary">"paid"</span>.
                        Then the seller will ship the product within the set Handling Time. If necessary, you can
                        contact the seller to send a message.
                        After the seller ships the product, they will mark the Shipment Status as <span
                            class="text-primary">"shipped"</span> and provide the Shipping Company Name and Package
                        Tracking Number, allowing you to track the shipping status.
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