@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Buy Requirement List
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Entry Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">
                                            COVID-19 MASKS
                                        </td>
                                        <td class="align-middle">
                                            10000
                                        </td>
                                        <td class="align-middle">
                                            John
                                        </td>
                                        <td class="align-middle">
                                            buyertesting@hotmail.com
                                        </td>
                                        <td class="align-middle">
                                            0861111111
                                        </td>
                                        <td class="align-middle">
                                            29 Nov 2020
                                        </td>
                                        <td class="align-middle">
                                            <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="id2" value="1">
                                                <div class="slider round"></div>
                                            </label>
                                            <a title="View" href="" class="btn m-1 btn-sm btn-success"><i
                                                    class="fas fa-eye    "></i></a>
                                            <a title="Delete" href="" class="btn m-1 btn-sm btn-primary"><i
                                                    class="fas fa-trash    "></i></a>

                                        </td>
                                    </tr>

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
    {{-- <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.update.status.user') }}',
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
    </script> --}}
@endsection
