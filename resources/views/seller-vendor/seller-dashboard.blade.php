@extends('seller-vendor.seller-frame')
@section('seller-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card my-4 py-3 rounded-0 shadow">
                    <div class="image bg-white d-flex flex-column justify-content-center align-items-center">
                        <a href="{{ route('seller.vendor.gallery') }}" style="height: 5rem; width: 5rem"
                            class="rounded-circle overflow-hidden">
                            <img style=" height: 100%; width: 100%; object-fit: fill;  object-position: center;border-radius: 50%; "
                                src="
                                @if ($seller->profile != '') 
                                {{ asset('uploads/profile/' . $seller->profile) }}
                                @else
                                https://www.shutterstock.com/image-vector/vector-design-avatar-dummy-sign-600nw-1290556063.jpg 
                            @endif" />
                        </a>
                        <span class="name mt-3 fs-5 fw-bolder">
                            Hi {{ $seller->first_name }}
                        </span>
                        <small class="text-muted">
                            <i class="fa fa-envelope me-2" aria-hidden="true"></i>
                            {{ $seller->email }}
                        </small>
                        <small class="text-muted">
                            <i class="fa fa-phone me-2" aria-hidden="true"></i> 
                            {{ $seller->phone }}
                        </small>

                        <div class="d-flex mt-3">
                            <a href="{{ route('seller.edit.registration', auth()->user()->ref_no) }}" class="btn btn-primary">Edit
                                Profile</a>
                        </div>
                        <div class="my-2">
                            <span style="font-size: 13px" class="fw-bold d-block text-center">
                                Member Status:
                                {{ $packageData->package->name }}
                            </span>
                            <span style="font-size: 13px" class="fw-bold d-block text-center">
                                Expiry Date: {{ date('d-m-Y', strtotime($packageData->expire_at)) }}
                            </span>
                        </div>
                        <a href="javaScript:void(0)" data-bs-toggle="modal" data-bs-target="#prealert"
                            class="btn btn-secondary mt-2">
                            Upgrade Member Package
                        </a>
                    </div>
                </div>

                <div class="card mt-1 shadow rounded-0">
                    <div class="card-header pb-0">
                        <h6 class="px-1 fw-bolder">Active Social Media</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (isset($seller->social->isFacebook) && $seller->social->isFacebook == 1)
                                <a href="https://www.facebook.com/{{ isset($seller->social->facebook) ? $seller->social->facebook : '' }}"
                                    class="col-sm-4 mb-2 ">
                                    <div class="card text-white d-flex justify-content-center align-items-center"
                                        style="background-color: #2525fe; height: 3rem">
                                        <i class="fa-brands fa-facebook-square fs-3"></i>
                                    </div>
                                </a>
                            @endif
                            @if (isset($seller->social->isInstagram) && $seller->social->isInstagram == 1)
                                <a href="https://www.instagram.com/{{ isset($seller->social->instagram) ? $seller->social->instagram : '' }}"
                                    class="col-sm-4 mb-2">
                                    <div class="card text-white d-flex justify-content-center align-items-center"
                                        style="background: linear-gradient(to bottom, #833ab4, #fd1d1d); height: 3rem;">
                                        <i class="fa-brands fa-instagram fs-3"></i>
                                    </div>
                                </a>
                            @endif
                            @if (isset($seller->social->isX) && $seller->social->isX == 1)
                                <a href="https://www.x.com/{{ isset($seller->social->x) ? $seller->social->x : '' }}"
                                    class="col-sm-4 mb-2">
                                    <div class="card text-white d-flex justify-content-center align-items-center"
                                        style="background-color: #1da1f2; height: 3rem">
                                        <i class="fab fa-twitter fs-3"></i>
                                    </div>
                                </a>
                            @endif

                            @if (isset($seller->social->isLinkedIn) && $seller->social->isLinkedIn == 1)
                                <a href="https://www.linkedin.com/in/{{ isset($seller->social->linkedin) ? $seller->social->linkedin : '' }}"
                                    class="col-sm-4 mb-2">
                                    <div class="card text-white d-flex justify-content-center align-items-center"
                                        style="background-color: #0077b5; height: 3rem">
                                        <i class="fab fa-linkedin-in fs-3"></i>
                                    </div>
                                </a>
                            @endif
                            @if (isset($seller->social->isSkype) && $seller->social->isSkype == 1)
                                <a href="skype:{{ isset($seller->social->skype) ? $seller->social->skype : '' }}?chat"
                                    class="col-sm-4 mb-2">
                                    <div class="card text-white d-flex justify-content-center align-items-center"
                                        style="background-color: #0077b5; height: 3rem">
                                        <img src="{{asset('skype.png')}}" style="height:30px;">
                                    </div>
                                </a>
                            @endif
                            @if (isset($seller->social->isYoutube) && $seller->social->isYoutube == 1)
                                <a href="https://www.youtube.com/{{ isset($seller->social->youtube) ? $seller->social->youtube : '' }}"
                                    class="col-sm-4 mb-2">
                                    <div class="card text-white d-flex justify-content-center align-items-center"
                                        style="background-color: #b50000; height: 3rem">
                                        <i class="fab fa-youtube fs-3"></i>
                                    </div>
                                </a>
                            @endif
                            <div class="text-center">
                                <a href="{{ route('seller.social-media') }}" class="btn btn-primary mt-3">Edit Setting</a>
                            </div>
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
                                                <h5 class="card-title py-1 fs-5">{{ $unreadMessages ?? 0 }} Messages</h5>
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
                                <div class="card rounded-0 text-white bg-success">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">
                                                    Store
                                                </p>
                                                <h5 class="card-title py-1 fs-5">{{ $storeInfo }} Infos</h5>
                                            </div>
                                            <div class="col-4 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-shop fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('seller.newstate.store') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">
                                                    Products
                                                </p>
                                                <h5 class="card-title py-1 fs-5">{{ $productInfo }} Infos</h5>
                                            </div>
                                            <div class="col-5 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-bullhorn fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('seller.newstate.product') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-info">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">
                                                    Tenders
                                                </p>
                                                <h5 class="card-title py-1 fs-5">{{ $tenderInfo }} Infos</h5>
                                            </div>
                                            <div class="col-5 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-hammer fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('seller.newstate.tender') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">Quotations</p>
                                                <h5 class="card-title py-1 fs-5">{{ $quotationInfo }} Infos</h5>
                                            </div>
                                            <div class="col-5 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-exchange-alt fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('seller.newstate.quotation') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-3">
                                <div class="card rounded-0 text-white bg-secondary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <p class="card-text fs-5 mb-0 fw-bolder pb-0">Sale Provision</p>
                                                <h5 class="card-title py-1 fs-5">
                                                    {{ $wallets ?? 0 }} Infos
                                                </h5>
                                            </div>
                                            <div class="col-3 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-wallet fs-1"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer py-2 text-center">
                                        <a href="{{ route('mywallet.show') }}" class="text-light">More Info
                                            <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow rounded-0 mb-4">
                    <div class="card-header fw-bolder">Company Usefull Links</div>
                    <div class="card-body">
                        <div class="row usefull_links">
                            
                            <div class="col-sm-6 col-md-4 mb-2">
                                <a href="{{ route('seller.edit.registration', auth()->user()->ref_no) }}" style="height: 100%"
                                    class="card rounded-0 p-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{ asset('world-business/images/vendor-ico/order.png') }}"
                                                height="60" width="60" alt="" />
                                        </div>
                                        <div class="col-9">
                                            <h5 class="fs-6 mb-0 pb-o fw-bold">
                                                Company Profile
                                            </h5>
                                            <small class="text-muted lh-sm mt-0 pt-0">Update Your Business Profile</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 mb-2 col-md-4">
                                <a href="{{ route('seller.certificates') }}"
                                    style="height: 100%" class="card rounded-0 p-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{ asset('certificate.png') }}"
                                                height="60" width="60" alt="" />
                                        </div>
                                        <div class="col-9">
                                            <h5 class="fs-6 mb-0 pb-o fw-bold">Company Certifications</h5>
                                            <small class="text-muted mt-0 pt-0">Update Your Company Certifications</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-4 mb-2">
                                <a href="{{ route('create.spotlight.store') }}" style="height: 100%"
                                    class="card rounded-0 p-1">
                                    <div class="row">
                                        <div class="col-3">
                                            <img src="{{ asset('world-business/images/vendor-ico/amazon.png') }}"
                                                height="55" width="60" alt="" />
                                        </div>
                                        <div class="col-9">
                                            <h5 class="fs-6 mb-0 pb-o fw-bold">Spotlight Store</h5>
                                            <small class="text-muted lh-sm mt-0 pt-0">Set your spotlight store</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="prealert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="card-body pt-0">
                        <h5 class="fs-5 fw-bolder text-center">
                            Please note, that if if you upgrade your membership package, the credit for your
                            existing membership will expire and not be credited.
                        </h5>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            <a href="{{ route('seller.upgrade.member.package') }}" class="btn btn-secondary">Upgrade</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
