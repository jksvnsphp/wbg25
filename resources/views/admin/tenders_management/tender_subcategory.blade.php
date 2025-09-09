@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Tender Sub Categories
                        <div class="d-flex">
                            
                            <button onclick="toggleAddCategory()" class="btn btn-sm btn-secondary">Add Category</button>

                        </div>
                    </div>

                    <div class="card-body pb-0">
                        <div class="card my-4 rounded-0 d-none" id="category_card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                Add Category
                            </div>
                            <form method="POST" action="{{route('admin.store.tender.subcategory')}}" class="card-body pb-0" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="form-control" placeholder="Enter the category name">
                                        <input type="hidden" name="isok" value="{{ old('isok') ? 1 : 1 }}">
                                        <input type="hidden" name="category_id" value="{{ $category_id }}">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="text" value="{{ old('meta_keyword') }}" name="meta_keyword"
                                            class="form-control" id="meta_keyword" placeholder="Enter the meta keyword(s).">
                                        @error('meta_keyword')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <input type="file" name="image" id="image">
                                        @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Enter the meta desciption">{{ old('meta_description') }}</textarea>
                                        @error('meta_description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 px-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <style>
                            td {
                                padding: 5px 7px !important;
                            }
                        </style>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Category</th>

                                        <th>Image</th>
                                        <th>Sub Category</th>
                                        <th>Active / Inactive </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($items as $key => $item)
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
                                            <td class="align-middle">
                                                <a href="">
                                                    {{ $item->category->name }}
                                                </a>
                                            </td>
                                            
                                            <td>
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($item->status) type="checkbox"
                                                        id="id{{ $item->id }}" value="1">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{route('admin.edit.tender.subcategory',$item->id)}}" class="btn m-1 btn-sm btn-success"> <i
                                                        class="fas fa-edit    "></i> </a>
                                                <a href="{{route('admin.delete.tender.subcategory',$item->id)}}" id="delete" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash"
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
    <script>
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('id', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.status.tender.subcategory') }}',
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
