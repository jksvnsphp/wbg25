@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Profile Gallery</h4>
        <!-- <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">+ Add Certificate</a> -->
    </div>

    <table class="table table-bordered">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Image1</th>
                <th>Image2</th>
                <th>Image3</th>
                <th>Image4</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $users?->company?->name }}  </td>
                    <td>
                      {{ $user->email ?? 'N/A' }}      
                    </td>
                    <td>
                        @if ($user->->company?->image_1)
                            <img src="{{ asset('uploads/profile/' . $user->->company?->image_1) }}" width="100">
                        @else
                            <span class="text-muted">No Profile  Banner</span>
                        @endif    
                    </td>

                    <td>
                        @if ($user->->company?->image_2)
                            <img src="{{ asset('uploads/profile/' . $user->->company?->image_2) }}" width="100">
                        @else
                            <span class="text-muted">No Profile  Banner</span>
                        @endif    
                    </td>
                    <td>
                        @if ($user->->company?->image_3)
                            <img src="{{ asset('uploads/profile/' . $user->->company?->image_3) }}" width="100">
                        @else
                            <span class="text-muted">No Profile  Banner</span>
                        @endif  
                   
                    <td>

                       <td>
                        @if ($user->->company?->image_4)
                            <img src="{{ asset('uploads/profile/' . $user->->company?->image_4) }}" width="100">
                        @else
                            <span class="text-muted">No Profile  Banner</span>
                        @endif  
                   
                    <td>



                        <!-- <a href="{{ route('admin.certificates.edit', $users->id) }}" class="btn btn-sm btn-warning">Edit</a> -->
                        <form action="{{ route('admin.profile-banners.destroy', $users->id) }}" method="POST" style="display:inline-block;">
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
