@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Show  Videos
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
                                        <th>Company Name </th>
                                        <th>Product Video Title</th>
                                        <th>Entry Date</th> 
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
  <tbody>
                                    @foreach ($products as $key => $item)
                                        <tr>
                                            <td class="align-middle">{{ $key + 1 }}</td>
                                            <td class="align-middle">
                                                <a href="">
                                                    {{ $item->name }}
                                                </a>
                                            </td>

                                            <td class="align-middle ">
                                                <div style="height: 4rem; width:4rem;">
                                                    @if (isset($item->image) && !empty($item->image))
                                                        <img src="{{ asset('uploads/tender_category/' . $item->image) }}"
                                                            class="h-100 w-100" alt="">
                                                    @else
                                                        <img src="{{ asset('dashboard/img/imgnotfound.jpg') }}"
                                                            class="h-100 w-100" alt="">
                                                    @endif
                                                </div>
                                            </td>
                                             
                                            <td>
                                                 
                                                 {{ $item->video->video_url ?? 'N/A' }}
                                            </td>
                                            <td class="align-middle">
                                                <a href="#" class="btn m-1 btn-sm btn-success"> <i
                                                        class="fas fa-edit    "></i> </a>
                                                <a href="#" id="delete" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash"
                                                        aria-hidden="true"></i> </a>

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
