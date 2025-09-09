@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <h6 class="fs-5 text-light py-3 px-3">Store New State</h6>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="row my-3 justify-content-center">
                            <div class="col-md-11">
                                <ul class="d-flex flex-wrap justify-content-around align-items-center " style="list-style: disc !important;">
                                    <li style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline  d-block mt-3 position-relative" href="{{route('seller.get.multiply.products')}}">
                                            My listed Multiply Products ({{ $listedRMultiplyProduct }})
                                             <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$listedMultiplyProduct ?? 0}}</span>
                                        </a>
                                    </li>
                                    <li style="list-style: disc !important;">
                                        <a class="text-dark text-decoration-underline d-block  mt-3 position-relative" href="{{route('seller.get.msold.products')}}">
                                            My sold Multiply Products ({{ $soldRProducts }})
                                             <span class="position-absolute top-4 start-100 translate-middle badge rounded-pill bg-danger">{{$soldProducts ?? 0}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" onclick="window.history.back()" class="btn text-light">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection
