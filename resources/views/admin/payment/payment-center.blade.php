@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        All Payments
                    </div>
                    <div class="card-body pb-0">
                        <div class="row my-3">
                            <div class="col-sm-4">
                                <select name="payment" id="payment" class="form-control">
                                    <option value="">Sort By Payment Status</option>
                                    <option value="1">Complete</option>
                                    <option value="2">Pending</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="package" id="package" class="form-control">
                                    <option value="">Sort By Package Type</option>
                                    <option value="1">Bronce</option>
                                    <option value="2">Silver</option>
                                    <option value="3">Gold</option>
                                    <option value="4">Platinum</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Amount</th>
                                        <th>Package Type</th>
                                        <th>Payment Status</th>
                                        <th>Transaction Date</th>
                                        <th>Payment Method</th>
                                        <th>Payment Id</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="align-middle p-2">1</td>
                                        <td class="align-middle p-2">Rihana Khan</td>
                                        <td class="align-middle p-2">rihanakhan@gmail.com</td>
                                        <td class="align-middle p-2">$49,00</td>
                                        <td class="align-middle p-2">Silver</td>
                                        <td class="align-middle p-2">Payment Completed</td>
                                        <td class="align-middle p-2">23 Jan 2024</td>
                                        <td class="align-middle p-2">PayPal</td>
                                        <td class="align-middle p-2">paypal_764746</td>
                                        <td class="align-middle p-2">
                                            <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="id2" value="1">
                                                <div class="slider round"></div>
                                            </label>
                                            <a title="Delete" href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

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
