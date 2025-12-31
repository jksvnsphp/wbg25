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
    <option value="">All Packages</option>
    @foreach($packages as $package)
        <option value="{{ $package->id }}">{{ $package->name }}</option>
    @endforeach
</select>
                            </div>
                        </div>
                        <div class="table-responsive" id="tableData">
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
                                    <!--<tr>
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
                                    </tr>--->
									
									
									



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
function loadPaymentData(page = 1) {

    let payment = $('#payment').val();
    let package = $('#package').val();
    let search  = $('#dataTable_filter input').val();

    $.ajax({
        url: "{{ route('admin.payment.center.ajax') }}",
        data: {
            payment: payment,
            package: package,
            search: search,
            page: page
        },
        success: function(res) {
            $("#tableData").html(res.html);
        }
    });
}

// Load default table on page load
loadPaymentData();

// Filter change
$("#payment, #package").change(function() {
    loadPaymentData();
});

// Search as typing
$("#dataTable_filter input").keyup(function() {
    loadPaymentData();
});

// Pagination click
$(document).on("click", ".pagination a", function(e){
    e.preventDefault();
    var page = $(this).attr("href").split("page=")[1];
    loadPaymentData(page);
});
</script>

@endsection
