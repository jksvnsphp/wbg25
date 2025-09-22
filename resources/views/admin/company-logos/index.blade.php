@extends('admin.main-dashboard-frame')

@section('admin-content')
<div class="container-fluid">
    <h4 class="mb-3">Company Logos</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Company Logo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            @foreach($companies as $key => $company)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->user->email ?? '-' }}</td>
                <td>
                    @if($company->company_logo)
                        <img src=" @if (isset($company->company_logo) && $company->company_logo != '') {{ asset('uploads/profile/' . $company->company_logo) }} @else {{ asset('uploads/logo/default-logo.png') }} @endif " width="80">
                        
                    @else
                        <span class="text-muted">No Logo</span>
                    @endif
                </td>
                <td>
                    <!-- <a href="{{ route('admin.company-logos.edit', $company->id) }}" class="btn btn-sm btn-primary">Edit</a> -->
                    <form action="{{ route('admin.company-logos.destroy', $company->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table> 

 <div class="d-flex justify-content-center">
                            {{ $companies->links('pagination::bootstrap-5') }}
                        </div>
    
</div>
@endsection
