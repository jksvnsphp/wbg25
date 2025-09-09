@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header d-flex justify-content-between rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        eMail Templates
                        <a href="{{route('admin.bulk.email.send')}}" class="btn btn-secondary">Bulk Send</a>
                        <a href="{{route('admin.add.email.template')}}" class="btn btn-secondary">Add New</a>
                    </div>
                    <style>

                    </style>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Type</th>
                                        <th>Subject</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            Send OTP
                                        </td>
                                        
                                        <td>
                                            Subject Of Email Is here
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-info"><i class="fas fa-edit    "></i></a>
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
