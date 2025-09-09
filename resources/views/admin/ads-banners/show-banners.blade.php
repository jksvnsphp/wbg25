@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Home Banners List in Abstract & Contemporary Paintings Category
                    </div>
                    <div class="card-body pb-0">

                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Banner Image Name</th>
                                        <th>Position</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="align-middle p-2">1</td>
                                        <td class="align-middle p-2">image_267363.jpg</td>
                                        <td class="align-middle p-2">Top</td>
                                        <td class="align-middle p-2">10 Jan 2024</td>
                                        <td class="align-middle p-2">15 May 2024</td>

                                        <td>
                                            <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="id9" checked value="1">
                                                <div class="slider round"></div>
                                            </label>
                                            <a href="" title="Edit" class="btn m-2 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                            <a href="" title="Delete" class="btn m-2 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
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
@endsection
