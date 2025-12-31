@extends('admin.main-dashboard-frame')

@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header d-flex justify-content-between rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        eMail Templates
                        <a href="{{route('admin.bulk.email.send')}}" class="btn btn-secondary">Bulk Send</a>
                        <a href="{{ route('admin.email_templates.create') }}" class="btn btn-secondary">Add New</a>
                    </div>
                     @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
                    <style>

                    </style>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Type</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th width="120">Action</th>
                                    </tr>

                                </thead>
                                <tbody>
                                     @forelse($templates as $index => $template)
                                    <tr>
                                         <td>{{ $index + 1 }}</td>
                    <td>{{ $template->type }}</td>
                    <td>{{ $template->subject }}</td>
                    <td>
                        @if($template->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.email_templates.edit', $template->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.email_templates.destroy', $template->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this template?')">Delete</button>
                        </form>
                    </td>
                                    </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">No email templates found</td></tr>
                                    @endforelse
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
