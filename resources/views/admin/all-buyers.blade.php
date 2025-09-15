@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Show Buyers
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Buyer Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>Join Date</th>
                                        <th>Member Type</th>
                                        <th>Login Details</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($buyers as $key => $buyer)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td> {{ $buyer->first_name . ' ' . $buyer->last_name }} </td>
                                            <td> {{ $buyer->email }} </td>
                                            <td>
                                                @if ($buyer->countryData->image??'')
                                                    <img src="{{asset('uploads/country_flags/'.$buyer->countryData->image)}}" style="height: 30px;" alt="">
                                                
                                                @endif
                                                <small class="mt-2"> {{$buyer->countryData->name??''}} </small>
                                            </td>

                                            <td>
                                                {{ $buyer->created_at->format('d M, Y') }} 
                                            </td>
                                            <td>
                                                
                                            {{ $buyer->account_type }} </td>
                                            
                                            
                                            <td>Login Deatils: 
                                                Email {{ $buyer->email }}</td>
                                            <td>
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($buyer->status) type="checkbox"
                                                        id="checkbox{{ $buyer->id }}">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                                {{-- <a title="View" href="" class="btn m-1 btn-sm btn-secondary"> <i
                                                        class="fas fa-eye    "></i> </a> --}}
                                                <a title="Edit" href="{{route('admin.edit.user',$buyer->id)}}" class="btn m-1 btn-sm btn-success"> <i
                                                        class="fas fa-edit    "></i> </a>
                                                <a title="Delete" href="{{route('admin.delete.user',$buyer->id)}}" id="delete" class="btn m-1 btn-sm btn-danger"> <i
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
    {{-- <script>
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script> --}}

    <script>
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
    </script>
@endsection
