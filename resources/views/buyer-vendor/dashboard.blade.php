@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card my-4 py-3 rounded-0 shadow">
                    <div class="image bg-white d-flex flex-column justify-content-center align-items-center">
                        <div style="height: 5rem; width: 5rem" class="rounded-circle overflow-hidden">
                            <img style="height: 100%;width: 100%;object-fit: fill;object-position: center;border-radius: 50%;"src="@if ($buyer->profile!='')
                                    {{asset('uploads/profile/'.$buyer->profile)}}
                                @else
                                    https://www.shutterstock.com/image-vector/vector-design-avatar-dummy-sign-600nw-1290556063.jpg
                                @endif" />
                        </div>
                        <span class="name mt-3 fs-5 fw-bolder">Hi {{$buyer->first_name}} Buyer</span>
                        <small class="text-muted"><i class="fa fa-envelope me-2" aria-hidden="true"></i>
                            {{$buyer->email}}</small>
                        <small class="text-muted"><i class="fa me-2 fa-phone" aria-hidden="true"></i> {{$buyer->phone}}</small>

                        <div class="d-flex justify-content-around w-100 flex-wrap mt-3">
                            <a href="{{route('buyer.complete.profile',$buyer->ref_no)}}" class="btn btn-primary">Edit Profile</a>
                            <a href="{{ route('buyer.upgrade.to.seller',$buyer->ref_no) }}" class="btn btn-secondary">Upgrade to seller</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card shadow rounded-0 my-4">
                    <div class="card-header fw-bolder">New State</div>
                    <div class="card-body">
                        <div class="row details-card-v">
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-warning">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">
                                                    Inbox
                                                </p>
                                                <h5 class="card-title py-1 fs-5">{{ $unreadMessages }} Messages</h5>
                                            </div>
                                            <div class="col-5 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-envelope fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('inbox.show') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-10">
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">Purchased Products</p>
                                                <h5 class="card-title py-1 fs-5">{{ $purchasedProductCount }} Infos</h5>
                                                
                                            </div>
                                            <div class="col-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-archive fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('buyer.purchased.product') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">Quotations</p>
                                                <h5 class="card-title py-1 fs-5">{{ $quotationInfo }} Infos</h5>
                                            </div>
                                            <div class="col-3 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-exchange-alt fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('buyer.newstate.quotation') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-secondary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <p class="card-text fs-4 mb-0 fw-bolder pb-0">
                                                    Tenders
                                                </p>
                                                <h5 class="card-title py-1 fs-5"> {{ $tenderInfo }} Infos</h5>
                                            </div>
                                            <div class="col-4 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-bullhorn fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('buyer.newstate.tender') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
