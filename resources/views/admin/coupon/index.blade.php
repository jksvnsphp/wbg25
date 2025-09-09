@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div
                        class="card-header d-flex justify-content-between rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Coupons
                        <a href="{{ route('admin.create.coupon') }}" class="btn btn-primary">Add Promotion</a>
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Promotion Code</th>
                                        <th>Promotion Name</th>
                                        <th>Discount</th>
                                        <th>Start date</th>
                                        <th>End date</th>
                                        <th>Active/Inactive</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($coupons as $key => $coupon)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td> {{ $coupon->code }} </td>
                                            <td> {{ $coupon->name }} </td>
                                            <td> {{ $coupon->discount }} </td>
                                            <td>
                                                {{ $coupon->start_date ?? '' }}
                                            </td>
                                            <td>{{ $coupon->end_date }}</td>
                                            <td>
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($coupon->is_active) type="checkbox"
                                                        id="checkbox{{ $coupon->id }}">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a title="Edit" href="{{ route('admin.edit.coupon', $coupon->id) }}"
                                                        class="btn m-1 btn-sm btn-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.delete.coupon', $coupon->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete"
                                                            class="btn m-1 btn-sm btn-danger">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@section('custom-js')
    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.update.status.coupon') }}',
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        toastr.success('Status updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status');
                    }
                });
            });
        });
    </script>
@endsection
