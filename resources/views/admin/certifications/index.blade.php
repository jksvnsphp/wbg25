@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Company Certificates</h4>
        <!-- <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">+ Add Certificate</a> -->
    </div>

    <table class="table table-bordered" id="dataTable">
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
                        @php 
                           //echo "<pre/>";
                           $certificatesD=  getCertificatesList( ($cert->user?->company?->vendor_id) ?? 0 );
                           //print_r($certificates );die;
                           $image1= $certificatesD[0]['image'] ?? '';
                           $image2= $certificatesD[1]['image'] ?? '';
                           $image3= $certificatesD[2]['image'] ?? '';
                           $image4= $certificatesD[3]['image'] ?? '';
                        @endphp

                    <img src="{{ asset('uploads/certificates/' . $image1) }}" width="100"></td>
                    <td> <img src="{{ asset('uploads/certificates/' . $image2) }}" width="100"></td>
                    <td> <img src="{{ asset('uploads/certificates/' . $image3) }}" width="100"></td>
                    <td> <img src="{{ asset('uploads/certificates/' .$image1) }}" width="100"></td>
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
