@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Add Static Page
                    </div>
                    <div class="card-body pb-0">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 ">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Title: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <input name="title" type="text" class="form-control form-control-user">
                            </div>


                            <div class="col-sm-12 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Matter: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <textarea name="matter" id="editor" rows="6" class="form-control"></textarea>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="" class="form-label fs-3 font-weight-bolder text-dark">Priority: <i
                                        class="fas fa-asterisk fs-1 text-danger"></i></label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>

                            <div class="p-2 pb-0 mb-0">
                                <button class="btn btn-sm btn-primary">Save</button>
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
