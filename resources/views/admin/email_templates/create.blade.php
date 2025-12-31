@extends('admin.main-dashboard-frame')

@section('admin-content')
<div class="container mt-4">
    <h3>Add Email Template</h3>

    <form method="POST" action="{{ route('admin.email_templates.store') }}">
        @csrf

        <div class="mb-3">
            <label>Type</label>
            <input type="text" name="type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="editor">Body (HTML supported)</label>
            <textarea name="body" id="editor" rows="10" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Template</button>
        <a href="{{ route('admin.email_templates.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
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
