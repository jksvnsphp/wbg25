@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                    Buy Tenders
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product Name</th>
                                        <th>Company Name</th>
                                        <th>Email</th>
                                        <th>Image</th>
                                        <th>Entry Date</th>
                                        <th>Approval</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                    
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
