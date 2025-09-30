@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Quotations Images</h4>
  
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Quotation Title</th>
                <th>Email</th>
                <th>Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quotations as $quotation)
                <tr>
                    <td>
                       @php 
                      // echo "<pre>";    
                       // print_r($quotation->toArray()); die;
                          $user = \App\Models\User::find($quotation->user_id);
                       @endphp
                        {{ $loop->iteration }}</td>
                    <td>
                    
                    {{ $user?->company?->name }}  </td>
                     <td>
                    
                    {{ $quotation?->product_service }}  </td>
                    <td>
                      {{ $user->email ?? 'N/A' }}      
                    </td>
                    <td>

                        @if($quotation->image_1)
                            <img src="{{ asset('uploads/quotation/' . $quotation?->image_1) }}" style="height:50px" alt="">
                        @else
                            <span>No Image</span>
                        @endif 
                     
                    </td>
                   
                    <td>
                       
                        <form action ="#" method="POST" style="display:inline-block;">
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
                            {{ $quotations->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection
