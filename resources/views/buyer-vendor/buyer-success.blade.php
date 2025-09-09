@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card my-4 py-3 rounded-0 shadow">
                    <div class="image bg-white d-flex flex-column justify-content-center align-items-center">
                        <div style="height: 5rem; width: 5rem" class="rounded-circle overflow-hidden">
                            <img
                                style="height: 100%;width: 100%;object-fit: fill;object-position: center;border-radius: 50%;"src="@if ($buyer->profile != '') {{ asset('uploads/profile/' . $buyer->profile) }}
                                @else
                                    https://www.shutterstock.com/image-vector/vector-design-avatar-dummy-sign-600nw-1290556063.jpg @endif" />
                        </div>
                        <span class="name mt-3 fs-5 fw-bolder">Hi {{ $buyer->first_name }} Buyer</span>
                        <small class="text-muted"><i class="fa fa-envelope me-2" aria-hidden="true"></i>
                            {{ $buyer->email }}</small>
                        <small class="text-muted"><i class="fa me-2 fa-phone" aria-hidden="true"></i>
                            {{ $buyer->phone }}</small>

                        <div class="d-flex mt-3">
                            <a href="{{ route('buyer.complete.profile', $buyer->ref_no) }}" class="btn btn-primary">Edit
                                Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card shadow rounded-0 my-4 " style="min-height:16rem;">

                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="row details-card-v justify-content-center  ">
                            <h5 class="text-success fs-5 text-center">{{ $message }}</h5>
                            <div class="col-12 text-center mt-4">
                                <a href="{{ route('buyer.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
