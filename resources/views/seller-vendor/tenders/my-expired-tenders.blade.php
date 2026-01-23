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
                <div class="d-flex align-items-center">
                    <h6 class="fs-5 text-light py-2 mt-0 px-3 mb-0">My Tenders</h6>
                    <a href="{{ route('seller.get.tender') }}" class="btn btn-sm me-3 {{ Route::currentRouteName() == 'seller.get.tender' ? 'btn-secondary disabled' : 'btn-light' }}">Active</a>
                    <a href="{{ route('seller.get.expired-tender') }}" class="btn btn-sm {{ Route::currentRouteName() == 'seller.get.expired-tender' ? 'btn-secondary disabled' : 'btn-light' }}"> Inactive </a>
                </div>
                <a href="{{ route('seller.add.tender') }}" class="btn btn-secondary">+ Add Tender</a>
            </div>
            <div class="card rounded-0">
                <div class="card-body">
                    <h6>Here a overview of your tenders:</h6>
                    <div class="table-responsive">
                        <table class="table  table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th colspan="2">Information</th>

                                    <th>Expired</th>
                                    <th>Condition</th>
                                    <th>Price</th>
                                    <th>Price</th>
                                    <th>Status</th>

                                    <th>ReList</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                use Carbon\Carbon;
                                @endphp
                                @foreach ($tenders as $tender)
                                <tr data-tender-id="{{ $tender->id }}" @if($tender->isRead==0) class="table-info" @endif>
                                    <td width="10%">
                                        <div class="table-img">
                                            <img src="{{ asset('uploads/tender/' . $tender->image_1) }}"
                                                style="height: 100%; width: 100%" alt="" />
                                        </div>
                                    </td>
                                    <td width="25%">
                                        <p>{{ $tender->name }}</p>
                                    </td>

                                    <td>
                                        @php
                                        $newDate = Carbon::parse($tender->created_at)->addDays(
                                        $tender->duration,
                                        );
                                        @endphp
                                        {{ $newDate->toDateString() }}
                                    </td>
                                    <td>
                                        {{ preg_replace('/([a-z])([A-Z])/', '$1 $2', $tender->tender_condition) }}

                                    </td>
                                    <td>
                                        &euro; {{ $tender->price }}
                                    </td>
                                    <td>
                                        {{ $tender->type==1?"Sell":"Buy" }}
                                    </td>

                                    <td>
                                        <div class="form-check form-switch" title="Status">
                                            <input class="form-check-input" @checked($tender->status)
                                            data-name="status" type="checkbox" id="flexSwitchCheckChecked">
                                        </div>
                                    </td>


                                    <td>
                                        <a href="{{ route('seller.edit.tender',$tender->slug) }}" title="relist" class="btn btn-secondary btn-sm me-2">
                                            <i class="fa fa-rotate text-white" aria-hidden="true"></i> Re-List
                                        </a>

                                    </td>


                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('seller.edit.tender',$tender->slug) }}" title="Edit" class="btn btn-info me-2">
                                                <i class="fa fa-edit text-white" aria-hidden="true"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-tender-id="{{ $tender->id }}"
                                                title="Delete" class="btn btn-primary me-2 delete-tender">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
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
        $('.form-check-input').on('change', function() {
            let checkbox = $(this);
            let key = checkbox.data('name');
            let value = checkbox.is(':checked') ? 1 : 0;
            let tenderId = checkbox.closest('tr').data(
                'tender-id');

            $.ajax({
                url: '{{ route("seller.status.tender") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    tender_id: tenderId,
                    key: key,
                    value: value
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred. Please try again.');
                    console.log(xhr.responseText);
                }
            });
        });
    });


    $(document).ready(function() {
        $('.delete-tender').on('click', function(e) {
            e.preventDefault();

            let tenderId = $(this).data('tender-id');

            if (confirm("Are you sure you want to delete this tender?")) {
                $.ajax({
                    url: '{{ route("seller.delete.tender") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tender_id: tenderId
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $(`a[data-tender-id="${tenderId}"]`).closest('tr').remove();
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