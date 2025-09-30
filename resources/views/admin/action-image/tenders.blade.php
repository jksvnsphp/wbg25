@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Tenders Images</h4>
  
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Tender Title</th>
                <th>Email</th>
                <th>Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tenders as $tender)
                <tr>
                    <td>
                       @php 
                       // echo "<pre>";    
                       /// print_r($tender->toArray()); die;
                          $user = \App\Models\User::find($tender->vendor_id);
                       @endphp
                        {{ $loop->iteration }}</td>
                    <td>
                    
                    {{ $user?->company?->name }}  </td>
                     <td>
                    
                    {{ $tender?->name }}  </td>
                    <td>
                      {{ $user->email ?? 'N/A' }}      
                    </td>
                    <td>

                        @if($tender->image1)
                            <img src="{{ asset('uploads/tender/' . $tender?->image1) }}" style="height:50px" alt="">
                        @else
                            <span>No Image</span>
                        @endif 
                     
                    </td>
                   
                    <td>
                       
                        <form action="{{ route('admin.tenders.destroy', $tender->id) }}" method="POST" style="display:inline-block;">
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
                            {{ $tenders->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection
