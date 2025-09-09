@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header bg-dark text-light">
                        Import Quotation Category CSV
                    </div>
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="csv" class="form-label">CSV File</label>
                                    <input id="fileInput" type="file" accept=".csv" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <button type="submit" id="uploadButton" class="btn btn-primary mt-3">Upload</button>
                            </div>
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
            $('#uploadButton').click(function() {
                $('#uploadButton').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...');
                var formData = new FormData();
                var fileInput = $('#fileInput')[0].files[0];
                formData.append('csv_file', fileInput);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('admin.import.quotation.category') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        $('#uploadButton').prop('disabled', false).html('Upload');
                        if (response.status) {
                            alert('File uploaded successfully');
                        } else {
                            alert('Failed to upload file');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#uploadButton').prop('disabled', false).html('Upload');
                        console.error(xhr.responseText);
                    }
                });
                
            });
        });
    </script>
@endsection
