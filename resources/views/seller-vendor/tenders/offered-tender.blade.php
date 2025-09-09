@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <div id="loadingOverlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div class="spinner-border text-light" role="status"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 3rem; height: 3rem;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My Offers On Tenders</h6>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th colspan="2">Information</th>
                                        <th>Tender</th>
                                        <th>Price</th>
                                        <th>Offered On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tenders as $tender)
                                        <tr @if($tender->isUserRead==0) class="table-info"  @endif>
                                            <td colspan="2">
                                                <a href="{{ route('show.tender', $tender->tender->slug) }}"
                                                    class="d-flex flex-column align-items-center text-primary fw-bolder">
                                                    <img src="{{ asset('uploads/tender/' . $tender->tender->image_1) }}"
                                                        style="height:4rem;width:4rem;" class="rounded-2"
                                                        alt="{{ $tender->tender->name }}">

                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('show.tender', $tender->tender->slug) }}"
                                                    class="text-primary fw-bold">
                                                    {{ $tender->tender->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <p class="mb-0 pb-0">Offered Price: USD
                                                    {{ number_format($tender->offer_price) }}</p>
                                                <p class="mb-0 pb-0">Tender Price: USD
                                                    {{ number_format($tender->tender->price) }}</p>
                                            </td>
                                            <td>{{ date('d-M-Y h:i A', strtotime($tender->created_at)) }}</td>
                                            <td>
                                                @if (isset($tender->status) && $tender->status == 'accept')
                                                    <div
                                                        class="d-flex align-items-center justify-content-center flex-column">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('world-business/images/vendor-ico/businessdeal.jpg') }}"
                                                                style="height: 4rem;" alt="">
                                                        </div>
                                                        <h6>
                                                            US$ {{ $tender->counter_price ?? 0 }}
                                                        </h6>
                                                        <button
                                                            data-name="{{ $tender->tender->vendor->first_name ?? '' }} {{ $tender->tender->vendor->last_name ?? '' }}"
                                                            data-email="{{ $tender->tender->vendor->email ?? '' }}"
                                                            data-phone="{{ $tender->tender->vendor->phone ?? '' }}"
                                                            type="button" class="btn btn-primary btn-sm contact-btn">
                                                            Seller Contact
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="badge bg-secondary">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a id="delete"
                                                    href="{{ route('seller.delete.tender-offer', $tender->id) }}"
                                                    class="text-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Seller Contact Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="sellerName"></span></p>
                    <p><strong>Email:</strong> <span id="sellerEmail"></span></p>
                    <p><strong>Phone:</strong> <span id="sellerPhone"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('seller-custome-js')
    <script>
        $(document).ready(function() {
            $(".contact-btn").on("click", function() {
                let name = $(this).data("name");
                let email = $(this).data("email");
                let phone = $(this).data("phone");

                $("#sellerName").text(name);
                $("#sellerEmail").text(email);
                $("#sellerPhone").text(phone);

                $("#contactModal").modal("show");
            });
        });
    </script>
@endsection
