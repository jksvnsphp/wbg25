@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Profile Banners</h4>
        <!-- <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">+ Add Certificate</a> -->
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Profile banner</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user?->company?->name }}  </td>
                    <td>
                      {{ $user->email ?? 'N/A' }}      
                    </td>
                    <td>
                        @if ($user->company?->profile_banner)
                            <img src="{{ asset('uploads/profile/' . $user->company?->profile_banner) }}" width="100">
                        @else
                            <span class="text-muted">No Profile  Banner</span>
                        @endif    
                    </td>
                   
                    <td>
 
                        <form action="{{ route('admin.profile-banners.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No banners found.</td></tr>
            @endforelse
        </tbody>
    </table>

    
 <div class="d-flex justify-content-center">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection
