@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Company Certificates</h4>
        <!-- <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">+ Add Certificate</a> -->
    </div>

    <table class="table table-bordered">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Image1</th>
                <th>Image2</th>
                <th>Image3</th>
                <th>Image4</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($certificates as $cert)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cert->user?->company?->name }}  </td>
                    <td>
                      @if ($cert->user?->company?->other_certificate)
                            @php
                                $others = json_decode($cert->user?->company?->other_certificate);
                                
                            @endphp
                      @endif    
                    <img src="{{ asset('uploads/certificates/' . $others[1]) }}" width="100"></td>
                    <td> <img src="{{ asset('uploads/certificates/' . $others[2]) }}" width="100"></td>
                    <td> <img src="{{ asset('uploads/certificates/' . $others[3]) }}" width="100"></td>
                    <td> <img src="{{ asset('uploads/certificates/' . $others[4]) }}" width="100"></td>
                    <td>
                        <!-- <a href="{{ route('admin.certificates.edit', $cert->id) }}" class="btn btn-sm btn-warning">Edit</a> -->
                        <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No certificates found.</td></tr>
            @endforelse
        </tbody>
    </table>

    
 <div class="d-flex justify-content-center">
                            {{ $certificates->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection
