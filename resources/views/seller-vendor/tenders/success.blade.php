@extends('seller-vendor.seller-frame')

@section('seller-main-content')
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-2 bg-primary py-3">
            <h6 class="fs-5 text-light px-3">Tender Published Successfully</h6>

            <div class="card rounded-0 mt-3">
                <div class="card-body">

                    <!-- SUCCESS MESSAGE -->
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="fa fa-check-circle me-2 fs-4"></i>
                        <strong>
                            Congratulations! Your Tender has been successfully published.
                        </strong>
                    </div>

                    <!-- TENDER SUMMARY -->
                    <div class="row mt-4">
                       

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Tender Title</label>
                            <p class="border rounded p-2">{{ $tender->name ?? '-' }}</p>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Quantity</label>
                            <p class="border rounded p-2">{{ $tender->quantity ?? '-' }}</p>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="fw-bold">Price</label>
                            <p class="border rounded p-2">
                                {{ $tender->currency ?? 'USD' }} {{ number_format($tender->price ?? 0, 2) }}
                            </p>
                        </div>
 <?php
                        //   echo "<pre>";
                        //   print_r($tender);
                        //   echo "</pre>";die;
                          ?>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Condition</label>
                            <p class="border rounded p-2">{{ $tender->tender_condition ?? '-' }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Duration</label>
                            <p class="border rounded p-2">{{ $tender->duration ?? '-' }}</p>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="fw-bold">Description</label>
                            <div class="border rounded p-3">
                                {!! $tender->description ?? '-' !!}
                            </div>
                        </div>

                    </div>

                    <!-- SHIPPING SUMMARY 
                    <div class="mt-4">
                        <h6 class="fw-bold text-primary">Shipping Information</h6>

                        <p><strong>Partner:</strong> {{ $tender->shipping_partner ?? '-' }}</p>
                        <p><strong>Method:</strong> {{ $tender->shipping_method ?? '-' }}</p>
                    </div> -->

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('seller.edit.tender', $tender->slug) }}" class="btn btn-outline-primary">
                            Edit Tender
                        </a>

                        <a href="{{ route('seller.get.tender') }}" class="btn btn-secondary">
                            Go to My Tenders
                        </a>

                        <a href="{{ route('seller.dashboard') }}" class="btn btn-light">
                            Dashboard
                        </a>
                    </div>

                </div>
            </div>

            <!-- BACK -->
            <div class="mt-3">
                <button type="button" onclick="window.history.back()" class="btn text-light">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>

        </div>
    </div>
</section>
@endsection