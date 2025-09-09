@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Browse Only .csv extension File and Import their Records.
                    </div>
                    <style>
                        .csv_format sup {
                            font-size: 13px !important;
                        }
                    </style>
                    <div class="card-body pb-0">
                        <table class="table table-bordered">
                            <tr class=" bg-light ">
                                <td>
                                    <p class="font-weight-normal csv_format text-center   fs-2  ">
                                        <span>(1) PERSON-NAME <sup class="text-danger">*</sup> </span>
                                        <span>(2) Email <sup class="text-danger">*</sup> </span>
                                        <span>(3) Company Name <sup class="text-danger">*</sup> </span>
                                        <span>(4) Address</span>
                                        <span>(5) Country <sup class="text-danger">*</sup> </span>
                                        <span>(6) State <sup class="text-danger">*</sup> </span>
                                        <span>(7) City <sup class="text-danger">*</sup> </span>
                                        <span>(8) Category <sup class="text-danger">*</sup> </span>
                                        <span>(9) Sub Category <sup class="text-danger">*</sup> </span>
                                        <span>(10) Next Sub Category <sup class="text-danger">*</sup> </span>
                                        <span>(11) Pin Code</span>
                                        <span>(12) Mobile No <sup class="text-danger">*</sup> </span>
                                        <span>(13) Package Type (A_F = Free/A_P = Silver/A_G = Gold/A_S = Platinum)<sup
                                                class="text-danger">*</sup> </span>
                                        <span>(14) Description</span>
                                        <span>(15) profile_complite <sup class="text-danger">*</sup> </span>
                                    </p>
                                    <p class="pb-0 mb-0"><strong class="text-danger">All * sign is mandatory. Maximum 1000
                                            enters at time</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    You can download example file from here. <a href=""><i class="fa fa-download"
                                            aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    **Please donot remove heading row from file
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group d-flex flex-column mb-0">
                                        <label for="file" class="font-weight-bold fs-2">Import File:</label>
                                        <input type="file" name="csv" id="file" accept=".csv">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button class="btn btn-primary btn-sm">Import Data</button>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
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
