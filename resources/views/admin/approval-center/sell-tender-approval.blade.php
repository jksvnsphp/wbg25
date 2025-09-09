@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                       Sell Tenders
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Company Name</th>
                                        <th>Email</th>
                                        <th>Image</th>
                                        <th>Entry Date</th>
                                        <th>Approve</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody >
                                    <tr >
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">Fasion Store</td>
                                        <td class="align-middle">fasionstore@gmail.com</td>
                                        <td class="align-middle">
                                            <div style="height: 4rem; width:4rem;">
                                                <img src="{{asset('dashboard/img/imgnotfound.jpg')}}" class="h-100 w-100" alt="">
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            12 Jan 2023
                                        </td>
                                        <td class="align-middle">
                                            <a href="" class="btn btn-primary btn-sm rounded-circle"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                                        </td>
                                        <td class="align-middle">
                                            <a href="" class="btn m-1 btn-sm btn-secondary"> <i class="fas fa-eye    "></i> </a>
                                            <a href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

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
