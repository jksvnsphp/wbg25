@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Multiply Product Images</h4>
  
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
        @php
            use Illuminate\Support\Facades\File;
        @endphp
@forelse ($products as $product)
    @php
        $vendor  = $product->vendor;
        $company = $vendor?->company;
        $firstImage = null;

        if (!empty($product->mainGallery)) {
            $gallery = json_decode($product->mainGallery, true);

            if (is_array($gallery) && isset($gallery[0]['image'])) {
                $firstImage = $gallery[0]['image'];
                
            }
        }
         $imagePath = public_path('uploads/products/' . $firstImage);
            if ($firstImage && !File::exists($imagePath)) {
                $firstImage = null;
                continue; // ✅ Skip this product and move to next loop
            }
    @endphp

    <tr>
        <td>{{ $loop->iteration }}</td>

        <td>{{ $company?->name ?? 'N/A' }}</td>

        <td>{{ $product->name }}</td>

        <td>{{ $vendor?->email ?? 'N/A' }}</td>

        <td>
            @if($firstImage)
                <img src="{{ asset('uploads/products/' . $firstImage) }}"
                     style="height:50px" alt="product image">
            @else
                <span>No Image</span>
            @endif
        </td>

        <td>
            <label title="Active/Inactive" class="switch round_switch">
                <input type="checkbox" checked>
                <div class="slider round"></div>
            </label>

            <form action="{{ route('admin.products.destroy', $product->id) }}"
                  method="POST" style="display:inline-block;">
                @csrf @method('DELETE')
                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                    Delete
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center">No products found.</td>
    </tr>
@endforelse
</tbody>
    </table>

    
 <div class="d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>

    
</div>
@endsection


@section('custom-js')
    <script>
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('id', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.status.tender.category') }}',
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        toastr.success('Status updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating status');
                    }
                });
            });
        });
    </script>
@endsection