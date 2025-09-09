@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        News
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
                                        <th>Company Name</th>
                                        <th>Title</th>

                                        <th>Published Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($newss as $key=>$news)
                                        
                                    <tr>
                                        <td class="align-middle">{{$key+1}}</td>
                                        <td class="align-middle">
                                            <img src="{{asset('uploads/news/'.$news->image)}}" style="height: 4rem;" class=" img-thumbnail "
                                                alt="">
                                        </td>
                                        <td class="align-middle">
                                            <p class="fs-2 font-weight-bold">{{$news->user->first_name.' '.$news->user->last_name}}</p>
                                        </td>
                                        <td class="align-middle">
                                            <p class="fs-2 font-weight-bold">
                                                {{Str::limit($news->title,120)}}
                                            </p>
                                        </td>


                                        <td>
                                            {{date('d M Y',strtotime($news->created_at))}}
                                        </td>
                                        <td>
                                            <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="checkbox{{$news->id}}" @checked($news->status) value="1">
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td>
                                            
                                            <a href="{{route('admin.edit.news',$news->id)}}" title="Edit" class="btn m-2 btn-sm btn-success"> <i
                                                    class="fas fa-edit    "></i> </a>
                                            <a href="{{route('admin.delete.news',$news->id)}}" id="delete" title="Delete" class="btn m-2 btn-sm btn-danger"> <i
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
                    url: '{{ route('admin.update.status.news') }}',
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        toastr.success('Status updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status',error);
                    }
                });
            });
        });
    </script>
@endsection
