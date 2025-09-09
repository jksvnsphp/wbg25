@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Add New SEO for page
                    </div>
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="page" class=" font-weight-bold fs-2">Page <span class="text-danger">*</span></label>
                                    <select name="page" id="page" class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Home</option>
                                        <option value="">Product</option>
                                        <option value="">News</option>
                                        <option value="">All Categories</option>
                                        <option value="">Supplier</option>
                                        <option value="">Suppliers</option>
                                        <option value="">Tenders</option>
                                        <option value="">Get Quote</option>
                                        <option value="">Source Pro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class=" font-weight-bold fs-2">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keywords" class=" font-weight-bold fs-2">Meta Keywords <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="keyword-1, keyword-2,..." name="keywords" id="keywords">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class=" font-weight-bold fs-2">Meta Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="8" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button class="btn btn-sm btn-primary">Submit</button>
                            </div>
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
