@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        All Mails
                    </div>
                    <div class="card-body pb-0">
                        <style>
                            td {
                                padding: 4px !important;
                                font-size: 14px !important;
                            }

                            td p {
                                font-size: 14px !important;
                                padding: 0px !important;
                                margin: 0px !important;
                            }
                        </style>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Sender Name</th>
                                        <th>Receiver Name</th>
                                        <th>Sender</th>
                                        <th>Receiver</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">
                                            Anjali Kapoor
                                        </td>
                                        <td class="align-middle">
                                            Rajeev Seller
                                        </td>
                                        <td class="align-middle">
                                            anjalitest@gmail.com
                                        </td>
                                        <td class="align-middle">
                                            devp7536@gmail.com
                                        </td>
                                        <td>
                                            iPhone Requirment
                                        </td>
                                        <td>
                                            2023-07-27
                                        </td>
                                        <td class="align-middle">
                                            <a href="" class="btn m-1 btn-sm btn-secondary"><i
                                                    class="fas fa-eye    "></i></a>
                                            <a href="" class="btn m-1 btn-sm btn-danger"><i
                                                    class="fas fa-link    "></i></a>
                                            <a href="" class="btn m-1 btn-sm btn-primary"><i
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
