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
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">Received Counter Offers</h6>
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
                                        <th scope="col">Counter Price</th>
                                        <th scope="col">Deal</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tenders as $quote)
                                        @php
                                            $tender = $quote->tender ?? [];
                                            $offer = $quote->offer ?? [];
                                            $sender = $offer->sender ?? [];
                                        @endphp
                                        <tr id="row-{{ $quote->id }}" @if($quote->isUserRead==0) class="table-info"  @endif>
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
                                                {{ $sender->first_name ?? '' }}
                                                {{ $sender->last_name ?? '' }}
                                            </td>
                                            <td>
                                                US$ {{ $tender->price }}
                                            </td>
                                            <td>
                                                You Offered US$ {{ $offer->offer_price }}
                                                <br />
                                                Counter Offered US$ {{ $quote->offer_price }}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="javaScript:void(0)" data-counter-id="{{ $quote->id }}"
                                                        data-offer-id="{{ $offer->id }}"
                                                        data-tender-id="{{ $tender->id }}"
                                                        class="acceptOffer btn btn-success me-2 btn-sm">
                                                        <i class="fa fa-check-circle"></i> Accept
                                                    </a>
                                                    <a href="javaScript:void(0)" data-counter-id="{{ $quote->id }}"
                                                        data-offer-id="{{ $offer->id }}"
                                                        data-tender-id="{{ $tender->id }}"
                                                        class="rejectOffer btn btn-secondary btn-sm">
                                                        <i class="fa fa-times-circle"></i> Reject
                                                    </a>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex">
                                                    <a href="javascript:void(0);" title="Delete"
                                                        class="btn btn-sm btn-primary delete-quotation"
                                                        data-counter-id="{{ $quote->id }}">
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
@endsection
@section('seller-custome-js')
    <script>
        $(document).ready(function() {
            $('.delete-quotation').on('click', function(e) {
                e.preventDefault();

                let counterId = $(this).data('counter-id');

                if (confirm("Are you sure you want to delete this counter tender offer?")) {
                    $.ajax({
                        url: '{{ route('seller.delete-received-counter.offer.tender') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            counter_id: counterId
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $(`a[data-counter-id="${counterId}"]`).closest('tr')
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
                let counterId = $(this).data("counter-id");
                let offerId = $(this).data("offer-id");
                let tenderId = $(this).data("tender-id");
                let row = $("#row-" + counterId);
                $.ajax({
                    url: "{{ route('seller.accept-counter.tender.offer') }}",
                    type: "POST",
                    data: {
                        counter_id: counterId,
                        offer_id: offerId,
                        tender_id: tenderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success("Offer Accepted Successfully!");
                        row.fadeOut(500, function() {
                            $(this).remove();
                        });
                    },
                    error: function() {
                        alert("Error accepting offer. Please try again.");
                    }
                });
            });
            $(".rejectOffer").click(function() {
                let counterId = $(this).data("counter-id");
                let offerId = $(this).data("offer-id");
                let tenderId = $(this).data("tender-id");
                let row = $("#row-" + counterId);
                $.ajax({
                    url: "{{ route('seller.reject-counter.tender.offer') }}",
                    type: "POST",
                    data: {
                        counter_id: counterId,
                        offer_id: offerId,
                        tender_id: tenderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success("Offer Rejected Successfully!");
                        row.fadeOut(500, function() {
                            $(this).remove();
                        });
                    },
                    error: function() {
                        alert("Error rejecting offer. Please try again.");
                    }
                });
            });

        });
    </script>
@endsection
