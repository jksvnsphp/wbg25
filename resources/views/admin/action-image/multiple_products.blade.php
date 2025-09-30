@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Products Images</h4>
  
    </div>

    <table class="table table-bordered" id="dataTable">
        <thead class="bg-dark text-light">
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Product Title</th>
                <th>Email</th>
                <th>Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>
                       @php 
                          $user = \App\Models\User::find($product->vendor_id);
                       @endphp
                        {{ $loop->iteration }}</td>
                    <td>
                    
                    {{ $user?->company?->name }}  </td>
                     <td>
                    
                    {{ $product?->name }}  </td>
                    <td>
                      {{ $user->email ?? 'N/A' }}      
                    </td>
                    <td>
                         @php

                           $gallery= $product->gallery->toArray(); 
                           // echo "<pre>";
                           // print_r($gallery[0]['image']); die;
                         
                          
                        @endphp
                        @if($gallery && isset($gallery['0']['image']))
                            <img src="{{ asset('uploads/products/gallery/' . $gallery[0]['image']) }}" style="height:50px" alt="">
                        @else
                            <span>No Image</span>
                        @endif 
                    </td>
                   
                    <td>
                       
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
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
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection
