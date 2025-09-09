@extends('external-user.external-frame')


@section('meta_data')
    <title>How to buy on World Business Guide – Your international Market</title>
    <meta name="description"
        content="To buy Products, bid on Tenders or Request for Quotation on World Business Guide – WBG24.com – Your international Market - you need to Join a free Buyer Account.">
    <meta name="keywords" content="How to buy, How to Bid, how to get Quotes, Buyer Account">
    <meta name="author" content="WBG24.com">
@endsection


@section('external-main-content')
    <!-- header section end here -->
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
    </style>
    <section class="container my-4">
        <div class="row">
            <div class="col-md-12 py-4 pt-5">
                <h3 class="fs-2 fw-bolder text-primary">How to start Buying on World Business Guide – WBG24.com</h3>
                <p class="text-primary mt-4 linehight">
                    Discover new Opportunities to buy Products, bid on Tenders, or to get individual Quotes globally.
                    Whether you're a business or an individual, the World Business Guide - WBG24.com - Your international
                    Market Platform simplifies the Purchasing Process.
                    Follow these Steps to become a WBG24.com Member and to make secure Transactions.
                </p>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-4">
                <nav id="navbar-example3" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                    <a class="navbar-brand fs-3 fw-bolder" href="#">How to Buy</a>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link" href="#item-1">Become a Member</a>
                        <a class="nav-link" href="#item-2">Browse & Search</a>
                        <a class="nav-link" href="#item-3">Place an Order</a>
                        <a class="nav-link" href="#item-4">Payment Options</a>
                        <a class="nav-link" href="#item-5">Track your Order</a>
                    </nav>
                </nav>
            </div>
            <div class="col-8">
                <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-offset="0" tabindex="0">
                    <h4 id="item-1" class="fw-bolder text-primary ">Become a Member</h4>
                    <p class="linehight">
                        You need to become a Member before you can start to Buying on World Business Guide - WBG24.com.
                        Create an Buyer or Seller Account to start Purchasing.
                        Visit the Sign-in Page and choose a Buyer or Seller Account.
                        Fullfill out the required Details on the Register Form and complete the Register Process.
                        Once you have complete your Registration Process, you need to verify your Email Adress to activate
                        your WBG24 Account.
                        A verified account gives you Access to secure Transactions and exclusive Offers.
                    </p>

                    <h4 id="item-2" class="fw-bolder text-primary mt-4">Browse & Search</h4>
                    <p class="linehight">
                        Explore a wide Range of Products and Tenders from verified Sellers worldwide.
                        Use Filters to narrow down your Search by Category, Price, or Rating.
                        Detailed Product Descriptions and High-Quality Images help you make an informed choice.
                        You can also reach out direct to Sellers for any Inquiries regarding Product Specifications, Bulk
                        Orders or Tenders.
                    </p>

                    <h4 id="item-3" class="fw-bolder text-primary mt-4">Place an Order</h4>
                    <p class="linehight">
                        Once you've found the right Product, click on "Buy now" or on “Add to Cart” and proceed to Checkout.
                        Or once you`ve found the right Tender, enter your Bid or click on "Buy now" and proceed to Checkout.
                        Double-Check your Order Summary before making the Payment.
                        After placing the Order, you will receive a Confirmation Email with the Details of your Purchase.
                    </p>

                    <h4 id="item-4" class="fw-bolder text-primary mt-4">Payment Options</h4>
                    <p class="linehight">
                        WBG24 offers Multiple Secure Payment Options, including Credit/Debit Cards, PayPal, and direct Bank
                        Transfers. Our encrypted Payment System ensures a safe Transaction Experience.
                        This ensures Trust between Buyers and Sellers. Always check the Payment Details before confirming to
                        avoid any errors.
                    </p>

                    <h4 id="item-5" class="fw-bolder text-primary mt-4">Track your Order</h4>
                    <p class="linehight">
                        Once your Order is paid, you need to set the Payment Status on the Product Detail, or Tender Detail
                        Site, to "paid“, that the Seller get this Information to start the shipping Process.
                        After the Seller has ship your Item out, he will also leave the Shipping Company and Shipping Number
                        on the Product Detail, or Tender Detail Page.
                        This Datas allows you to track the Shipping Staus.
                        Upon receiving the Order, check the Package Condition and Product Quality before Confirming the
                        Delivery and to Rate the Seller.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary" type="button" onclick="history.back()">
                    <i class="fa fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
    </section>
@endsection
