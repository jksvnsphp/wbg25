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
                {{ $heading }}
            </h3>
            <p class="text-primary mt-4" style="line-height: 1.5">{{ $subtext ?? '' }}</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4">
            <nav id="profileNav" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
                <a class="navbar-brand fs-4 fw-bolder text-primary" href="#">Spotlight Store</a>
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link text-primary" href="#listMultiplyProducts">List Multiply Products</a>
                    <a class="nav-link text-primary" href="#viewListedProducts">View Listed Multiply Products</a>
                    <a class="nav-link text-primary" href="#viewSoldProducts">View Sold Multiply Products</a>
                    <a class="nav-link text-primary" href="#uploadStoreGallery">Upload Store Gallery Image</a>
                    <a class="nav-link text-primary" href="#uploadStoreSearchKeys">Upload Store Search Keys</a>
                    <a class="nav-link text-primary" href="#uploadStoreMetaDatas">Upload Store Meta Datas</a>
                    <a class="nav-link text-primary" href="#viewSpotlightStore">View Spotlight Store</a>
                </nav>
            </nav>
        </div>
        <div class="col-lg-8">
            <div data-bs-spy="scroll" data-bs-target="#profileNav" data-bs-offset="0" tabindex="0">
                <!-- List Multiply Products -->
                <section id="listMultiplyProducts">
                    <h4 class="fw-bolder text-primary">How to list Multiply Products?</h4>
                    <iframe style="width: 100%;height:15rem;" class="mb-5" src="https://www.youtube.com/embed/n-lUAXKView?si=Rq3mizZx3umWak1P" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Spotlight Store"</span> -
                        Option <span class="text-primary">"List Multiply Products"</span>.
                    </p>
                    <p class="linehight">
                        Search on the Multiply Product Upload Form for a Category for your Product Listing. Enter the
                        Product Name, choose and select a Product Category Suggestion and click on <span
                            class="text-primary">Use</span>.
                    </p>
                    <p class="linehight">
                        Set the Condition and, if needed, the Item Specifics. Set Product Characteristics like Color,
                        Size, or others, and click on <span class="text-primary">Generate Combinations</span>.
                    </p>
                    <p class="linehight">
                        Upload your Main Gallery and Product Images and set Quantity and Prices. Upload a Product Video
                        if you have one.
                    </p>
                    <p class="linehight">
                        Enter the Product Title &amp; Description, set Shipping Cost, Shipping Regions, and Handling
                        Time. Set Accepted Returns and click on <span class="text-primary">"List &amp; Sell"</span>.
                    </p>
                </section>
                <hr>

                <!-- View Listed Multiply Products -->
                <section id="viewListedProducts">
                    <h4 class="fw-bolder text-primary">How to view my listed Multiply Products?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Spotlight Store"</span> -
                        Option <span class="text-primary">"My listed Multiply Products"</span>.
                    </p>
                    <p class="linehight">
                        Here you will find an overview of your listed Multiply Products. To change details on any
                        product, click on the <span class="text-primary">"Edit Button"</span>. You will be redirected to
                        the individual Product Upload Form, where you can update the details. Finally, confirm your
                        changes by clicking on <span class="text-primary">"Save Changes"</span>.
                    </p>
                </section>
                <hr>

                <!-- View Sold Multiply Products -->
                <section id="viewSoldProducts">
                    <h4 class="fw-bolder text-primary">How to view my sold Multiply Products?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Spotlight Store"</span> -
                        Option <span class="text-primary">"My sold Multiply Products"</span>.
                    </p>
                    <p class="linehight">
                        Here you will find an overview of your sold Multiply Products. If you click on the <span
                            class="text-primary">"Details"</span> button for any sold product, you will be forwarded to
                        the <span class="text-primary">"My sold Product Details"</span> page.
                    </p>
                    <p class="linehight">
                        On that page, you can see the Shipping Address and the Payment &amp; Shipment Status for the
                        sold product. Once the Buyer marks the Payment Status as <span
                            class="text-primary">"paid"</span> and you have received the payment, ship the product
                        within your set Handling Time.
                    </p>
                    <p class="linehight">
                        If needed, contact the Buyer to send a message. After shipping, mark the Shipment Status as
                        <span class="text-primary">"shipped"</span> and enter the Shipping Company Name along with the
                        Package Tracking Number.
                    </p>
                </section>
                <hr>

                <!-- Upload Store Gallery Image -->
                <section id="uploadStoreGallery">
                    <h4 class="fw-bolder text-primary">How to upload Store Gallery Image?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Spotlight Store"</span> -
                        Option <span class="text-primary">"Store Images"</span>.
                    </p>
                    <p class="linehight">
                        Here you can upload your Spotlight Store Gallery Image in an optimal size of <span
                            class="text-primary">2520 x 620 pixels</span>. Choose a file, click on <span
                            class="text-primary">"Upload"</span> to preview it, then click on <span
                            class="text-primary">"Save &amp; Publish"</span>.
                    </p>
                    <p class="linehight">
                        To view your Spotlight Store from the published perspective and check your Gallery Image upload,
                        click on <span class="text-primary">"View Store"</span> from the Dashboard Menu Bar under
                        "Spotlight Store".
                    </p>
                </section>
                <hr>

                <!-- Upload Store Search Keys -->
                <section id="uploadStoreSearchKeys">
                    <h4 class="fw-bolder text-primary">How to Upload Store Search Keys?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Spotlight Store"</span> -
                        Option <span class="text-primary">"Store Search Keys"</span>.
                    </p>
                    <p class="linehight">
                        Here you can enter up to 10 individual Store Search Keys, through which your Spotlight Store
                        will be listed under <span class="text-primary">"Stores"</span> via the Main Search Bar. After
                        entering your keys, click on <span class="text-primary">"Save &amp; Publish"</span>.
                    </p>
                </section>
                <hr>

                <!-- Upload Store Meta Datas -->
                <section id="uploadStoreMetaDatas">
                    <h4 class="fw-bolder text-primary">How to Upload Store Meta Datas?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Spotlight Store"</span> -
                        Option <span class="text-primary">"Store Meta Datas"</span>.
                    </p>
                    <p class="linehight">
                        Here you can enter your individual Spotlight Store Meta Title (max. 60 characters), Meta
                        Description (max. 160 characters), and Meta Keywords (max. 8 words). Click on <span
                            class="text-primary">"Save &amp; Publish"</span>. The entered meta datas will be used for
                        your Spotlight Store SEO.
                    </p>
                </section>
                <hr>

                <!-- View Spotlight Store -->
                <section id="viewSpotlightStore">
                    <h4 class="fw-bolder text-primary">How to view my Spotlight Store?</h4>
                    <p class="linehight">
                        Sign in - Dashboard Menu Bar - Select <span class="text-primary">"Spotlight Store"</span> -
                        Option <span class="text-primary">"View Store"</span>.
                    </p>
                    <p class="linehight">
                        Here you will find an overview of your Spotlight Store from the published perspective. You can
                        check your uploaded Store Images, share your Spotlight Store, view your rates and total number
                        of sold items, and review your used Multiply Product Categories along with all your uploaded
                        Multiply Products.
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