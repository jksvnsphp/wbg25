@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Member package
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Package Name</th>
                                        <th>Price</th>
                                        <th>Valid Days</th>
                                        <th>No. Of Product Limit</th>
                                        <th>Sell Tender Limit</th>
                                        <th>Buy Tender Limit</th>
                                        <th>News Limit</th>
                                        <th>Trade Leads Included</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($packages as $key => $package)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $package->name }}</td>
                                            <td>${{ $package->price }}</td>
                                            <td>{{ $package->validDays }}</td>
                                            <td>{{ $package->productLimit }}</td>
                                            <td>{{ $package->sellTenderLimit }}</td>
                                            <td>{{ $package->buyTenderLimit }}</td>
                                            <td>{{ $package->newsLimit }}</td>
                                            <td>{{ $package->tradeLeadsInclude }}</td>
                                            <td>
                                                <a href="{{ route('admin.member.edit.package', $package->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="fas fa-edit    "></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card rounded-0 mt-5">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Package Service
                        <a href="{{route('admin.add.package.service')}}" class="btn btn-secondary ">Add Package Service</a>
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Service Name</th>
                                        <th>Bronce</th>
                                        <th>Silver</th>
                                        <th>Gold</th>
                                        <th>Platinum</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($services as $key => $service)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $service->serviceName }}</td>
                                            <td>{{ $service->bronce == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $service->silver == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $service->gold == 1 ? 'Yes' : 'No' }}</td>
                                            <td>{{ $service->platinum == 1 ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($service->status) type="checkbox"
                                                        id="checkbox{{ $service->id }}">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>

                                                <a href="{{route('admin.edit.package.service',$service->id)}}" title="Edit" class="btn m-2 btn-sm btn-success"> <i
                                                        class="fas fa-edit    "></i> </a>
                                                <a href="{{route('admin.member.delete.package',$service->id)}}" title="Delete" id="delete" class="btn m-2 btn-sm btn-danger"> <i
                                                        class="fa fa-trash" aria-hidden="true"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach

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
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.member.status.package') }}',
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
    </script>

@endsection
