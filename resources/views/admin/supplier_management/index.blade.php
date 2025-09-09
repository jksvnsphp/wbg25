@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Suppliers Categories
                        <button onclick="toggleAddCategory()" class="btn btn-sm btn-secondary">Add Category</button>
                    </div>

                    <div class="card-body pb-0">
                        <div class="card my-4 rounded-0 {{ old('isok') ? 'd-block' : 'd-none' }}" id="category_card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                Add Category
                            </div>
                            <form method="POST" action="{{route('admin.store.supplier.category')}}" class="card-body pb-0" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="form-control" placeholder="Enter the category name">
                                        <input type="hidden" name="isok" value="{{ old('isok') ? 1 : 1 }}">
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
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Category</th>
                                        <th>Category Image</th>
                                        <th>Sub Category</th>
                                        <th>Active / Inactive</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($suppliers as $key => $supplier)
                                        <tr>
                                            <td class="align-middle">{{ $key + 1 }}</td>
                                            <td class="align-middle">
                                                <a href="">{{ $supplier->name }}</a>
                                            </td>

                                            <td class="align-middle ">
                                                <div style="height: 2rem; width:2rem;">
                                                    @if (isset($supplier->image) && !empty($supplier->image))
                                                        <img src="{{ asset('uploads/supplier_category/'.$supplier->image) }}"
                                                            class="h-100 w-100" alt="">
                                                    @else
                                                        <img src="{{ asset('dashboard/img/imgnotfound.jpg') }}"
                                                            class="h-100 w-100" alt="">
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{route('admin.suppliers.subcategory',$supplier->id)}}">{{$supplier->sub_categories_count}}</a>
                                            </td>
                                            <td>
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($supplier->status) type="checkbox" id="id{{ $supplier->id }}" value="1">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>

                                                <a href="{{route('admin.edit.suppliers.category',$supplier->id)}}" title="Edit" class="btn m-2 btn-sm btn-success"> <i
                                                        class="fas fa-edit    "></i> </a>
                                                <a id="delete" href="{{route('admin.delete.suppliers.category',$supplier->id)}}" title="Delete" class="btn m-2 btn-sm btn-danger"> <i
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
                var id = $(this).attr('id').replace('id', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.status.supplier.category') }}',
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
