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
                                src="@if ($seller->profile != '') {{ asset('uploads/profile/' . $seller->profile) }}
                                @else
                                    https://www.shutterstock.com/image-vector/vector-design-avatar-dummy-sign-600nw-1290556063.jpg @endif" />
                        </a>
                        <span class="name mt-3 fs-5 fw-bolder">Hi {{ $seller->first_name }}</span>
                        <small class="text-muted"><i class="fa fa-envelope me-2" aria-hidden="true"></i>
                            {{ $seller->email }}</small>
                        <small class="text-muted"><i class="fa me-2 fa-phone" aria-hidden="true"></i> {{ $seller->phone }}
                        </small>

                        <div class="d-flex mt-3">
                            <a href="{{ route('seller.edit.profile', $seller->ref_no) }}" class="btn btn-primary">Edit
                                Profile</a>
                        </div>
                        <div class="my-2">
                            <span style="font-size: 13px" class="fw-bold d-block text-center">Member Status:
                                {{ $packageData->package->name }}</span>
                            <span style="font-size: 13px" class="fw-bold d-block text-center">Expiry Date:
                                {{ date('d-m-Y', strtotime($packageData->expire_at)) }}</span>
                        </div>
                        <a href="{{ route('user.member.package') }}" class="btn btn-secondary mt-2">
                            Upgrade Member Package
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9 d-flex align-items-center">
                <div style="min-height: 22rem;" class="card shadow rounded-0 my-4 d-flex align-items-center ">
                    <div class="card-body d-flex align-items-center ">
                        <div class="row details-card-v justify-content-center">
                            <h5 class="text-secondary fs-5 text-center">{{ session('info-message') }}</h5>
                            <div class="col-sm-10 col-md-10 my-3">
                                <div class="card rounded-0 border-0 shadow-0">
                                    <div class="card-body">
                                        <p class="text-center">{{ session('info-content') }}</p>
                                        <div class="text-center">
                                            <a href="{{ route('seller.upgrade.member.package') }}" class="btn btn-secondary mt-2">
                                                Upgrade Member Package
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
                        Please note, that if you upgrade your membership package, the credit for your
                        existing membership will expire and not be credited.
                    </h5>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <a href="{{ route('seller.upgrade.member.package') }}" data-bs-toggle="modal" data-bs-target="#prealert" class="btn btn-secondary">Upgrade</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
