@extends('seller-vendor.seller-frame')

@section('seller-main-content')
    <style>
        .table-img {
            height: 6rem !important;
            width: 5rem !important;
            display: flex;
            justify-content: center;
        }

        .table-img img {
            object-fit: fill !important;
            object-position: center center;
        }

        .add_sc {
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        .form-input:focus {
            outline: none !important;
        }
    </style>
    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-2 bg-primary py-3">
                <div class="d-flex align-items-center justify-content-start mb-3">
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My Received Offers On Tenders</h6>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">

                                <thead>
                                    <tr>
                                        <th scope="col">Tender</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Sender Company Name</th>
                                        <th scope="col">Tender Price</th>
                                        <th scope="col">Offer Price</th>
                                        <th scope="col">Deal</th>
                                        <th scope="col">Counter Offer</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($receivedOffers as $quote)
                                        @php
                                            $tender = $quote->tender ?? [];
                                        @endphp
                                        <tr id="row-{{ $quote->id }}" @if($quote->isVendorRead==0) class="table-info"  @endif>
                                            <td>
                                                <a href="{{ route('show.tender', $tender->slug) }}"
                                                    style="width: 4rem !important; height:4rem !important;">
                                                    <img src="{{ asset('uploads/tender/' . $tender->image_1) }}"
                                                        class="w-100 h-100 rounded-2" alt=""
                                                        style="width: 4rem !important; height:4rem !important;">
                                                </a>
                                            </td>
                                            <td>
                                                {{ $tender->name }}
                                            </td>

                                            <td>
                                                {{ $quote->sender->first_name ?? '' }} {{ $quote->sender->last_name ?? '' }}
                                            </td>
                                            <td>
                                                US$ {{ $tender->price }}
                                            </td>
                                            <td>
                                                US$ {{ $quote->offer_price }}
                                            </td>
                                            <td style="vertical-align: middle; text-align:center;">
                                                @if (isset($quote->status) && $quote->status == 'pending')
                                                    <div
                                                        class="d-flex align-items-center justify-content-center ">
                                                        <a href="javaScript:void(0)" data-offer-id="{{ $quote->id }}"
                                                            data-tender-id="{{ $tender->id }}"
                                                            class="acceptOffer btn me-2 btn-success btn-sm">
                                                            <i class="fa fa-check-circle"></i> Accept
                                                        </a>
                                                        <a href="javaScript:void(0)" data-offer-id="{{ $quote->id }}"
                                                            data-tender-id="{{ $tender->id }}"
                                                            class="rejectOffer btn btn-secondary  btn-sm">
                                                            <i class="fa fa-times-circle"></i> Reject
                                                        </a>
                                                    </div>
                                                @elseif(isset($quote->status) && $quote->status == 'accept')
                                                    <div
                                                        class="d-flex align-items-center justify-content-center flex-column">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('world-business/images/vendor-ico/businessdeal.jpg') }}"
                                                                style="height: 4rem;" alt="">
                                                        </div>
                                                        <h6>
                                                            US$ {{ $quote->counter_price ?? 0 }}
                                                        </h6>
                                                        <button
                                                            data-name="{{ $quote->sender->first_name ?? '' }} {{ $quote->sender->last_name ?? '' }}"
                                                            data-email="{{ $quote->sender->email ?? '' }}"
                                                            data-phone="{{ $quote->sender->phone ?? '' }}" type="button"
                                                            class="btn btn-primary btn-sm contact-btn">
                                                            Buyer Contact
                                                        </button>

                                                    </div>
                                                @elseif(isset($quote->status) && $quote->status == 'reject')
                                                    <p class="badge bg-danger">Rejected</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($quote->status) && $quote->status == 'pending')
                                                    <form method="post" class="sendCounter" style="min-width:10rem; ">
                                                        <div class="input-group w-100">
                                                            <input type="text" placeholder="Price" name="counter_price"
                                                                class="form-control" />
                                                            <button
                                                                class=" input-group-btn btn btn-primary rounded-end-1 ">Send</button>
                                                            <input type="hidden" name="offer_id"
                                                                value="{{ $quote->id }}" />
                                                            <input type="hidden" name="tender_id"
                                                                value="{{ $tender->id }}" />
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="javascript:void(0);" title="Delete"
                                                        class="btn btn-sm btn-primary delete-tender"
                                                        data-offer-id="{{ $quote->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
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
                    <h5 class="modal-title" id="contactModalLabel">Buyer Contact Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="buyerName"></span></p>
                    <p><strong>Email:</strong> <span id="buyerEmail"></span></p>
                    <p><strong>Phone:</strong> <span id="buyerPhone"></span></p>
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
            $('.delete-tender').on('click', function(e) {
                e.preventDefault();

                let offerId = $(this).data('offer-id');

                if (confirm("Are you sure you want to delete this tender offer?")) {
                    $.ajax({
                        url: '{{ route('seller.delete-received.offer.tender') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            offer_id: offerId
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $(`a[data-offer-id="${offerId}"]`).closest('tr')
                                    .remove();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('An error occurred. Please try again.');
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $(".acceptOffer").click(function() {
                let quoteId = $(this).data("offer-id");
                let tenderId = $(this).data("tender-id");
                let row = $("#row-" + quoteId);
                $.ajax({
                    url: "{{ route('seller.accept.tender.offer') }}",
                    type: "POST",
                    data: {
                        offer_id: quoteId,
                        tender_id: tenderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success("Offer Accepted Successfully!");
                        location.reload(true);
                    },
                    error: function() {
                        alert("Error accepting offer. Please try again.");
                    }
                });
            });
            $(".rejectOffer").click(function() {
                let quoteId = $(this).data("offer-id");
                let tenderId = $(this).data("tender-id");
                let row = $("#row-" + quoteId);
                $.ajax({
                    url: "{{ route('seller.reject.tender.offer') }}",
                    type: "POST",
                    data: {
                        offer_id: quoteId,
                        tender_id: tenderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success("Offer Rejected Successfully!");
                        location.reload(true);
                    },
                    error: function() {
                        alert("Error rejecting offer. Please try again.");
                    }
                });
            });


            $(".sendCounter").submit(function(e) {
                e.preventDefault();

                let form = $(this);
                let counterPrice = form.find('input[name="counter_price"]').val();
                let offerId = form.find('input[name="offer_id"]').val();
                let tenderId = form.find('input[name="tender_id"]').val();

                $.ajax({
                    url: "{{ route('seller.send.offer-counter.offer') }}",
                    type: "POST",
                    data: {
                        counter_price: counterPrice,
                        offer_id: offerId,
                        tender_id: tenderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response?.status) {
                            toastr.success("Counter Offer Sent Successfully!");
                            form.find('input[name="counter_price"]').val("");
                        } else {
                            toastr.error(response?.message);
                        }
                    },
                    error: function() {
                        alert("Error sending counteroffer. Please try again.");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".contact-btn").on("click", function() {
                let name = $(this).data("name");
                let email = $(this).data("email");
                let phone = $(this).data("phone");

                $("#buyerName").text(name);
                $("#buyerEmail").text(email);
                $("#buyerPhone").text(phone);

                $("#contactModal").modal("show");
            });
        });
    </script>
@endsection
