@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Child Categories
                        
                        <button onclick="toggleAddCategory()" class="btn btn-sm btn-secondary">Add Category</button>
                    </div>
                    
                    <div class="card-body pb-0">
                        <div class="card my-4 rounded-0 {{ old('isok') ? 'd-block' : 'd-none' }}" id="category_card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                Add Category
                            </div>
                            <form class="card-body pb-0" method="post" action="{{ route('admin.add.custome-category') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter the category name" value="{{old('name')}}">
                                            <input type="hidden" name="isok" value="{{ old('isok') ? 1 : 1 }}">
                                            <input type="hidden" name="parent_id" value="{{$category->id}}">
                                            @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
                                            placeholder="Enter the title." value="{{old('title')}}">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="keyword" class="form-control @error('keyword') is-invalid @enderror" id="keyword"
                                            placeholder="Enter the  keyword(s)." value="{{old('keyword')}}">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="file" name="image" id="image">
                                        
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <textarea name="meta_description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter the desciption">{{old('description')}}</textarea>
                                    </div>
                                    <div class="mb-3 px-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Category Name</th>
                                        <th>Category Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($categories as $key => $pcat)
                                        <tr>
                                            <td class="align-middle">{{ $key + 1 }}</td>
                                            <td class="align-middle">
                                                <a href="">{{ $pcat->category_name }}</a>
                                            </td>

                                            <td class="align-middle ">
                                                @php
                                                    $imgPath=public_path('uploads/category-images/'. $pcat->classified_image);
                                                @endphp
                                                @if ($pcat->classified_image != '' && file_exists($imgPath))
                                                    <div style="height: 2rem; width:2rem;">
                                                        <img src="{{ asset('uploads/category-images/'. $pcat->classified_image) }}"
                                                            class="h-100 w-100" alt="">
                                                    </div>
                                                @else
                                                    <div style="height: 2rem; width:2rem;">
                                                        <img src="{{ asset('dashboard/img/imgnotfound.jpg') }}"
                                                            class="h-100 w-100" alt="">
                                                    </div>
                                                @endif
                                            </td>
                                            
                                           
                                            <td class="align-middle">
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($pcat->status) type="checkbox"
                                                        id="checkbox{{ $pcat->id }}">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td class="align-middle">
                                                
                                                <a href="{{route('admin.edit.custome-category',$pcat->id)}}" title="Edit" class="btn m-1 btn-sm btn-info"> <i
                                                        class="fas fa-edit    "></i> </a>
                                                <a href="{{route('admin.delete.custome-category',$pcat->id)}}" id="delete" title="Delete" class="btn m-1 btn-sm btn-danger"> <i
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
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.status.custome-category') }}',
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
