@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0 ">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Bulk Mail Send
                    </div>
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type" class=" font-weight-bold fs-2">Selected User Type <span
                                            class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="">All Seller</option>
                                        <option value="">All Active Seller</option>
                                        <option value="">All Inactive Seller</option>
                                        <option value="">All Buyer</option>
                                        <option value="">All Active Buyer</option>
                                        <option value="">All Inactive Buyer</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject" class=" font-weight-bold fs-2">Subject <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="subject" id="subject">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editor" class=" font-weight-bold fs-2">Mail Body <span
                                            class="text-danger">*</span></label>
                                    <textarea name="mail_body" id="editor" rows="8" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button class="btn btn-sm btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.28.0/dist/trumbowyg.min.js"></script>

    <script>
        $('#editor').trumbowyg();
    </script>
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
