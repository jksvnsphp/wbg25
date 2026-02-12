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
                <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My posted Quotations</h6>
                <a href="{{ route('myquotations.show') }}" class="btn btn-sm me-3 {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'myquotations.show' ? 'btn-secondary disabled' : 'btn-light' }}">Active</a>
                <a href="{{ route('myexpired.quotations.show') }}" class="btn btn-sm {{ \Illuminate\Support\Facades\Route::currentRouteName() == 'myexpired.quotations.show' ? 'btn-secondary disabled' : 'btn-light' }}">Inactive</a>
            </div>
            <div class="card rounded-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">

                            <thead>
                                <tr>
                                    <th scope="col">Quotation</th>
                                    <th scope="col">Product/Service</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Requirement Detail</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">ReList/Edit</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotations as $quotation)
                                <tr @if($quotation->isRead==0) class="table-info" @endif>
                                    <td>
                                        <a href="{{ route('user.source-pro.detail',$quotation->slug) }}" style="width: 4rem; height:4rem;">
                                            <img src="{{ asset('uploads/quotation/' . $quotation->image_1) }}"
                                                class="w-100 h-100 rounded-2" alt="" style="width: 4rem !important; height:4rem !important;">
                                        </a>
                                    </td>
                                    <td>
                                        {{ $quotation->product_service }}
                                    </td>
                                    <td>
                                        {{ $quotation->category->category_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ \Illuminate\Support\Str::limit($quotation->requirement_details, 100) }}
                                    </td>
                                    <td>
                                        {{ ucwords(str_replace('_', ' ', $quotation->type)) }}
                                    </td>
                                    <td>
                                        {{ $quotation->quantity }}
                                    </td>
                                    <td>
                                        @php
                                        $isExpired = \Illuminate\Support\Carbon::parse($quotation->created_at)
                                        ->addDays($quotation->duration)
                                        ->isPast();
                                        @endphp
                                        <a style="white-space: nowrap;" href="{{ route('seller.edit.quotation',$quotation->id) }}" title="{{ $isExpired ? 'Re-List' : 'Edit' }}" class="btn btn-sm btn-secondary">
                                            <i class="fa fa-rotate"></i> {{ $isExpired ? 'Re-List' : 'Edit' }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="javascript:void(0);" title="Delete"
                                                class="btn btn-sm btn-primary delete-quotation"
                                                data-quotation-id="{{ $quotation->id }}">
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

            if (confirm("Are you sure you want to delete this quotation?")) {
                $.ajax({
                    url: "{{ route('seller.delete.quotation') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        quotation_id: quotationId
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $(`a[data-quotation-id="${quotationId}"]`).closest('tr').remove();
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