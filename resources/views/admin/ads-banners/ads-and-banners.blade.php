@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Home Banners List
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Category</th>
                                        <th>Add Banner</th>
                                        <th>Show Banner</th>
                                        <th>Total Banners</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            Abstract & Contemporary Paintings
                                        </td>
                                        <td>
                                            <a class="btn-link fs-2 font-weight-bold" href="{{route('admin.add.new.banner')}}">Add Banner</a>
                                        </td>
                                        <td>
                                            <a class="btn-link fs-2 font-weight-bold" href="{{route('admin.show.ads.banner')}}">Show Banners</a>
                                        </td>
                                        <td>
                                            1
                                        </td>

                                        <td>
                                            <label class="switch round_switch">
                                                <input type="checkbox" id="id1" checked value="1">
                                                <div class="slider round"></div>
                                            </label>

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
