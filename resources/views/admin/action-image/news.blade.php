@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>News Images</h4>
  
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>News Title</th>
                <th>Email</th>
                <th>Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($news as $new)
                <tr>
                    <td>
                       @php 
                        //echo "<pre>";    
                        //print_r($new->toArray()); die;
                          $user = \App\Models\User::find($new->author_id);
                       @endphp
                        {{ $loop->iteration }}</td>
                    <td>
                    
                    {{ $user?->company?->name }}  </td>
                     <td>
                    
                    {{ $new?->title }}  </td>
                    <td>
                      {{ $user->email ?? 'N/A' }}      
                    </td>
                    <td>

                        @if($new->image)
                            <img src="{{ asset('uploads/news/' . $new?->image) }}" style="height:50px" alt="">
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
                            {{ $news->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection
