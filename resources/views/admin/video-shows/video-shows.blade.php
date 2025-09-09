@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Show Trades
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
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Venue</th>
                                        <th>Theme</th>
                                        <th>Entry Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">
                                            <img src="{{asset('dashboard/img/trade-shows/1657501756.png')}}" class=" img-thumbnail " alt="">
                                        </td>
                                        <td class="align-middle">
                                            <p class="fs-2 font-weight-bold">International Exhibition and Conference on Minerals Metals Metallurgy Materials</p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="fs-2 font-weight-normal">Pragati Maidan, New Delhi, India</p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="fs-2 font-weight-normal">MMMM 2022 (Minerals, Metals, Metallurgy and Materials) is the 13th Edition in the series and is scheduled on 25-27 August, 2022 at Pragati Maidan, New Delhi, India. It is one of the most significant events in the Indian Minerals, Metals and Materials market and will serve as an ideal B2B platform for entrepreneurs, CEO's, consultants, senior government officials, decision makers and trade delegations to congregate, brainstorm, showcase and forge meaningful business partnerships. This Business Pl</p>
                                        </td>
                                        <td>
                                            14 Feb 2024
                                        </td>
                                        <td>
                                            <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="id9" checked value="1">
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td>
                                            
                                            <a href="" title="View" class="btn m-1 btn-sm btn-secondary"> <i class="fas fa-eye    "></i> </a>
                                            <a href="" title="Edit" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                            <a href="" title="Delete" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

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
