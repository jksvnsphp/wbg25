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
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My Counter Quotes</h6>
                </div>
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">

                                <thead>
                                    <tr>
                                        <th scope="col">Quotation</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Counter User</th>
                                        <th scope="col">Quote</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotations as $quote)
                                        @php
                                            $quotation = $quote->quotation ?? [];
                                            $user = $quote->user ?? [];
                                            $offer = $quote->offer ?? [];
                                        @endphp
                                        <tr id="row-{{ $quote->id }}">
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
                                                {{ $user->first_name ?? '' }}{{ $user->last_name ?? '' }}
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
@section('buyer-custome-js')
    <script>
        $(document).ready(function() {
            $('.delete-quotation').on('click', function(e) {
                e.preventDefault();

                let quotationId = $(this).data('quotation-id');

                if (confirm("Are you sure you want to delete this counter quote offer?")) {
                    $.ajax({
                        url: '{{ route('buyer.delete.counter-quote.offer') }}',
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
    
@endsection
