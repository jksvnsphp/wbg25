@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Category Attributes
                        <button onclick="toggleAddCategory()" class="btn btn-sm btn-secondary">Add Category Attribute</button>
                    </div>

                    <div class="card-body pb-0">
                        <div class="card my-4 rounded-0 {{ old('isok') ? 'd-block' : 'd-none' }}" id="category_card">
                            <div
                                class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                                Add categor Attribute
                            </div>
                            <form class="card-body pb-0" method="post" action="{{ route('admin.add.attrcategory') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category_id }}">
                                <div class="row">


                                    <div class="col-md-6 form-group d-flex justify-items-center flex-column">
                                        <input type="hidden" name="isok" value="{{ old('isok') ? 1 : 1 }}">
                                        <label for="my-select">Attributes</label>
                                        <select name="attributes[]" id="my-select" multiple="multiple" class="w-100">
                                            @foreach ($allattributes as $attr)
                                                <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="isRequired">Is Required</label>
                                            <select name="isRequired" id="isRequired" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 px-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTableDynamic" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Attribute Name</th>
                                        <th>Data Type</th>
                                        <th>Is Required</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($category_attributes as $key => $pcat)
                                        <tr data-attribute-id="{{ $pcat->id }}">
                                            <td class="align-middle">{{ $key + 1 }}</td>
                                            <td class="align-middle">
                                                <a href="">{{ $pcat->attribute->name }}</a>
                                            </td>

                                            <td>

                                                {{ $pcat->attribute->dataType }}

                                            </td>
                                            <td>
                                                <label title="Is Required" class="switch round_switch">
                                                    <input @checked($pcat->isRequired) type="checkbox"
                                                        id="isRequired{{ $pcat->id }}" data-id="{{ $pcat->id }}"
                                                        data-name="isRequired" class="toggle-update">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>

                                            <td class="align-middle">
                                                <label title="Active/Inactive" class="switch round_switch">
                                                    <input @checked($pcat->status) type="checkbox"
                                                        id="status{{ $pcat->id }}" data-id="{{ $pcat->id }}"
                                                        data-name="status" class="toggle-update">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>

                                            <td class="align-middle">

                                                {{-- <a href="{{ route('admin.edit.subcategory', $pcat->id) }}" title="Edit"
                                                    class="btn m-1 btn-sm btn-info"> <i class="fas fa-edit    "></i> </a> --}}
                                                <a href="{{ route('admin.delete.attrcategory', $pcat->id) }}"
                                                    title="Delete" id="delete" class="btn m-1 btn-sm btn-danger"> <i
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
            $('#dataTableDynamic').DataTable();
            $(document).on('change', '.toggle-update', function() {
                var fieldValue = this.checked ? 1 : 0;
                var categoryId = $(this).data('id');
                var fieldName = $(this).data('name');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.status.category.attribute') }}',
                    data: {
                        id: categoryId,
                        field: fieldName,
                        value: fieldValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        toastr.success(fieldName.charAt(0).toUpperCase() + fieldName.slice(1) +
                            ' updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating ' + fieldName);
                    }
                });
            });
        });
    </script>


    <script>
        // Initialize multiple select on your regular select
        $("#my-select").multipleSelect({
            filter: true
        });
    </script>
@endsection
