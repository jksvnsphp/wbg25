@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <!-- information section -->
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fs-6 text-light fw-bolder pb-0 mb-0">
                        Request for Quotation Details
                    </h6>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#" class="text-primary"><i class="fa fa-arrow-left"
                                            aria-hidden="true"></i>
                                        Back</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#" class="text-primary">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page" class="text-primary">
                                    Buyer requirement listing
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Product Service name
                                </li>
                            </ol>
                        </nav>
                        <div class="row">
                            <div class="col-md-5" style="border: 1px solid #ddd">
                                <div class="card border-0 rounded-0">
                                    <div class="card-body img_view">
                                        <img class="large-view"
                                            src="{{ asset('world-business/images/product_images/450X450/1654.jpg') }}"
                                            class="img-fluid" alt="" />
                                    </div>
                                    <hr />
                                    <div class="card-footer border-0 d-flex bg-white">
                                        <div class="in-img">
                                            <img class="small-view"
                                                src="{{ asset('world-business/images/product_images/450X450/1636.jpg') }}"
                                                alt="" />
                                        </div>
                                        <div class="in-img">
                                            <img class="small-view"
                                                src="{{ asset('world-business/images/product_images/450X450/1836.jpg') }}"
                                                alt="" />
                                        </div>
                                        <div class="in-img">
                                            <img class="small-view"
                                                src="{{ asset('world-business/images/product_images/450X450/1831.jpg') }}"
                                                alt="" />
                                        </div>
                                        <div class="in-img">
                                            <img class="small-view"
                                                src="{{ asset('world-business/images/product_images/450X450/1654.jpg') }}"
                                                alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 product_details_single">
                                <h1 class="product_title mx-2 fs-5 fw-bolder mt-3">
                                    Nike Shoes
                                </h1>
                                <p class="mx-2 mt-2 d-block">Date posted : 2020-02-12</p>
                                <p class="mx-2 mt-2 d-block">Expired On : 2021-02-12</p>
                                <p class="mx-2 mt-2 d-block">
                                    Posted In:
                                    <img height="20"
                                        src="{{ asset('world-business/images/flageimage/60X30/Ireland.png') }}"
                                        alt="" />
                                    India
                                </p>

                                <div class="mt-4">
                                    <h5 class="mx-2 fw-semibold fs-6">
                                        Quantity Required: 500 Pieces
                                    </h5>
                                    <h5 class="mt-2 mx-2 fw-semibold fs-6">
                                        Asking Price: $300
                                    </h5>
                                </div>
                                <div class="mt-5 d-flex align-items-center" style="height: 7rem; border: 1px solid #202020">
                                    <h5 class="fw-bold mx-2">Description field</h5>
                                </div>
                                <a href="" class="mt-4 btn btn-primary">View Contact Details</a>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="card mb-3 rounded-0">
                                    <div class="card-header rounded-0 bg-body-secondary">
                                        <h5 class="py-2 pb-1 fw-semibold">Send Inquery</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="name" class="form-label">Name:</label>
                                                    <input type="text" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="subject" class="form-label">Subject:</label>
                                                    <input type="text" class="form-control" value="Sell used shoes" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="message" class="form-label">Message:</label>
                                                    <textarea name="message" id="message" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-1">
                                                    <label for="cdtext" class="form-label">Enter Text:</label>
                                                    <input type="text" class="form-control" />
                                                </div>
                                                <div class="form-group d-flex flex-column">
                                                    <label for="code" class="form-label">Verification Code</label>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('world-business/images/code.jpg') }}"
                                                            class="me-2" style="height: 2rem; width: 8rem"
                                                            alt="" />
                                                        <i class="fa-solid fa-rotate-right"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button class="btn btn-secondary mt-3">
                                                    Send Inquiry
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3 rounded-0">
                                    <div class="card-header rounded-0 bg-body-secondary">
                                        <h5 class="py-2 fw-semibold">Related RFQs</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="resposive-table">
                                            <table class="table-bordered table">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Country/Region</th>
                                                        <th>Qunatity</th>
                                                        <th>Time Left</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Lorem, ipsum dolor sit amet consectetur
                                                            adipisicing elit. Error, voluptates?
                                                        </td>
                                                        <td>India</td>
                                                        <td>
                                                            <a href="" class="btn btn-secondary rounded-0">20
                                                                Pieces</a>
                                                        </td>
                                                        <td>
                                                            <a href="" class="btn btn-primary rounded-0">30
                                                                Days</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light"><i
                            class="fas fa-arrow-left "></i> Back</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('buyer-custome-js')
    <script>
        $(document).ready(function() {
            $(".small-view").on("click", function() {
                var newSrc = $(this).attr("src");
                $(".large-view").attr("src", newSrc);
            });
        });
    </script>
@endsection
