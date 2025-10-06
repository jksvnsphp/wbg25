@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card rounded-0">
                <div class="card-header bg-dark text-light font-weight-bolder">
                    User Inquiry`s
                </div>
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>User Name</th>
                                     
                                    <th>User Email</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($inquiries as $index => $inquiry)
                                    <tr>
                                        <td>{{ $inquiries->firstItem() + $index }}</td>
                                        <td>{{ $inquiry->sender->name ?? $inquiry->name }}</td>
                                         
                                        <td>{{ $inquiry->sender->email ?? 'N/A' }}</td>
                                        <td>{{ $inquiry->subject }}</td>
                                        <td>{{ $inquiry->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.userinquiries.show', $inquiry->id) }}"
                                               class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.userinquiries.destroy', $inquiry->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Delete this inquiry?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No inquiries found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2">
                            {{ $inquiries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
