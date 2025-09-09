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
                            <a href="{{ route('seller.edit.registration', $seller->ref_no) }}" class="btn btn-primary">Edit
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
            <div class="col-md-9">
                <div class="card shadow rounded-0 my-4">
                    
                    <div class="card-body">
                        <div class="row details-card-v justify-content-center">
                            <h5 class="text-success fs-5 text-center">Congratulation, your news has {{ $what=="add"?"uploaded":"edited" }} successfully and listed
                                online now!</h5>
                            <div class="col-sm-6 col-md-8 my-3">
                                <div class="card rounded-0 shadow-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                
                                                <img src="{{ asset('uploads/news/' . $news->image) }}"
                                                    alt="" class="img-fluid">
                                            </div>
                                            <div class="col-md-8">
                                                <h5 class="text-dark fw-bolder"> {{ $news->title }}</h5>
                                                <a class="d-block text-primary mt-2" href="{{ route('read.news', $news->slug) }}">View Listed News</a>
                                               
                                                <a class="d-block text-primary mt-2" href="{{ route('seller.edit.news',$news->slug) }}">Edit Listed News</a>
                                                <a class="d-block text-primary mt-2" href="{{ route('seller.add.news') }}">Add New News</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('seller.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
                            </div>
                           
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
