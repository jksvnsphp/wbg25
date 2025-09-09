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
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My Received Counter Quotes</h6>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">

                                <thead>
                                    <tr>
                                        <th scope="col">Quotation</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Sender Company Name</th>
                                        <th scope="col">Quote</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Deal</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotations as $quote)
                                        @php
                                            $quotation = $quote->quotation ?? [];
                                            $sender = $quotation->vendor ?? [];
                                            $company = $sender->company ?? [];
                                            $offer = $quote->offer ?? [];
                                        @endphp
                                        <tr id="row-{{ $quote->id }}" @if($quote->isUserRead==0) class="table-info"  @endif>
                                            <td>
                                                <a href="{{ route('user.source-pro.detail', $quotation->slug) }}"
                                                    style="width: 4rem !important; height:4rem !important;">
                                                    <img src="{{ asset('uploads/quotation/' . $quotation->image_1) }}"
                                                        class="w-100 h-100 rounded-2" alt=""
                                                        style="width: 4rem !important; height:4rem !important;">
                                                </a>
                                            </td>
                                            <td>
                                                {{ $quotation->product_service }}
                                            </td>

                                            <td>
                                                {{ $sender->first_name ?? '' }}
                                                {{ $sender->last_name ?? '' }}
                                                ({{ $company->name ?? 'NA' }})
                                            </td>
                                            <td>
                                                You Offered US$ {{ $offer->offer_price }}
                                                <br />
                                                Counter Offered US$ {{ $quote->offer_price }}
                                            </td>
                                            <td>
                                                {{ $quotation->quantity }}
                                            </td>
                                            <td>
                                                <a href="javaScript:void(0)" data-counter-id="{{ $quote->id }}" data-offer-id="{{ $offer->id }}"
                                                    data-quotation-id="{{ $quotation->id }}"
                                                    class="acceptOffer btn btn-secondary btn-sm">
                                                    <i class="fa fa-check-circle"></i> Accept
                                                </a>
                                            </td>
                                            
                                            <td>
                                                <div class="d-flex">
                                                    <a href="javascript:void(0);" title="Delete"
                                                        class="btn btn-sm btn-primary delete-quotation"
                                                        data-quotation-id="{{ $quote->id }}">
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

                let quotationId = $(this).data('quotation-id');

                if (confirm("Are you sure you want to delete this counter quote offer?")) {
                    $.ajax({
                        url: '{{ route('seller.delete.counter-quote.offer') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            quotation_id: quotationId
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $(`a[data-quotation-id="${quotationId}"]`).closest('tr')
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
                let quoteId = $(this).data("offer-id");
                let quotationId = $(this).data("quotation-id");
                let row = $("#row-" + counterId);
                $.ajax({
                    url: "{{ route('seller.sender.accept-counter-quote') }}",
                    type: "POST",
                    data: {
                        counter_id: counterId,
                        quote_id: quoteId,
                        quotation_id: quotationId,
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

        });
    </script>
@endsection
