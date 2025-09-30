@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>store </h4>
  
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                 
                <th>Email</th>
                 
                   <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($spotlights as $spotlight)
                <tr>
                    <td>
                       @php 
                        // "<pre>";    
                         ///print_r($spotlight->toArray()); die;
                          $user = \App\Models\User::find($spotlight->id);
                       @endphp
                        {{ $loop->iteration }}</td>
                    <td>
                    
                    {{ $user?->company?->name }}  </td>
                     
                    <td>
                      {{ $user->email ?? 'N/A' }}      
                    </td>
                    <td>
                      
                        @if($user?->company?->spotlight_banner)
                            <img src="{{ asset('uploads/profile/' . $user?->company?->spotlight_banner) }}" style="height:50px" alt="">
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
                            {{ $spotlights->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection
