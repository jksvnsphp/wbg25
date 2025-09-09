@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <!-- information section -->
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fs-6 text-light fw-bolder pb-0 mb-0">
                        My Request for Quotation
                    </h6>
                    <a href="{{route('user.get.quotes')}}" class="btn btn-secondary">+ Post new Requirement</a>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">
                                <tbody>
                                    <tr>
                                        <td width="10%">
                                            <div class="table-img">
                                                <img src="{{asset('world-business/images/product_images/450X450/modern_lamp.jpeg')}}"
                                                    style="height: 100%; width: 100%" alt="" />
                                            </div>
                                        </td>
                                        <td>
                                            <p>Product/ Service Name</p>
                                        </td>
                                        <td>Qty 10000</td>
                                        <td>Expired 2024-02-27 / 7:45 PM</td>
                                        <td>
                                            <a href="{{route('buyer.view.details.quote')}}" class="btn btn-primary">Details</a>
                                        </td>
                                        <td>Received Quotes 125</td>
                                        <td>
                                            <a href="{{route('buyer.view.quotations')}}" class="btn btn-info text-light">View Quotes</a>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm me-2"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
