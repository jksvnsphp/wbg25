@extends('buyer-vendor.buyer-frame')
@section('buyer-main-content')
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
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My Submitted Quotes</h6>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">

                                <thead>
                                    <tr>
                                        <th scope="col">Quotation</th>
                                        <th scope="col">Product/Service</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Date & Time</th>
                                        <th scope="col">Offered Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotations as $quote)
                                        @php
                                            $quotation = $quote->quotation ?? [];
                                        @endphp
                                        <tr>
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
                                                {{ $quotation->quantity }}
                                            </td>
                                            <td>
                                                {{ date('d-m-Y h:i A', strtotime($quote->created_at)) }}
                                            </td>
                                            <td>
                                                US$ {{ $quote->offer_price }}
                                            </td>
                                            <td>
                                                @if (isset($quote->status) && $quote->status == 'accept')
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
                                                            data-name="{{ $quotation->vendor->first_name ?? '' }} {{ $quotation->vendor->last_name ?? '' }}"
                                                            data-email="{{ $quotation->vendor->email ?? '' }}"
                                                            data-phone="{{ $quotation->vendor->phone ?? '' }}"
                                                            type="button" class="btn btn-primary btn-sm contact-btn">
                                                            Seller Contact
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="badge bg-secondary">Pending</span>
                                                @endif
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
@section('buyer-custome-js')
    <script>
        $(document).ready(function() {
            $('.delete-quotation').on('click', function(e) {
                e.preventDefault();

                let quotationId = $(this).data('quotation-id');

                if (confirm("Are you sure you want to delete this quote?")) {
                    $.ajax({
                        url: '{{ route('buyer.delete.quote') }}',
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
