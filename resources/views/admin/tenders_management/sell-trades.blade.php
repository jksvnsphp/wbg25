@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Show Sell List
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product Name</th>
                                        <th>Company Name</th>
                                        <th>SEO Key</th>
                                        <th>Created</th>
                                        <th>Closed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>LED TV</td>
                                        <td>Samsung Pvt Ltd</td>
                                        <td>
                                            samsung led tv
                                        </td>
                                        <td>
                                            12 Jan 2023
                                        </td>
                                        <td>
                                            15 Jan 2023
                                        </td>
                                        <td>
                                            <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="id9" checked value="1">
                                                <div class="slider round"></div>
                                            </label>
                                            <a href="" title="View" class="btn m-1 btn-sm btn-secondary"> <i class="fas fa-eye    "></i> </a>
                                            <a href="" title="Edit" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                            <a href="" title="Delete" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

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
