@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        Product Approval
                    </div>
                    <div class="card-body pb-0">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Company Name</th>
                                        <th>Product Title</th>
 
                                        <th>Quantity</th>
                                        <th>Entry Date</th>
                                        <th>Duration Left Time</th> 
 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $index => $product)
                                        <tr>
                                            <td>
                                               
                                            {{ $products->firstItem() + $index }}</td>
                                             <td>{{getUserCompany($product->vendor->id) ?? 'N/A' }}</td>
                                            <td>{{ $product->name }}</td>
                                           
                                            <td>{{ $product->totalQty ?? 'N/A' }}</td>
                                          @php /* @endphp  <td>
                                                @if($product->image)
                                                    <img src="{{ asset('uploads/products/' . $product->image) }}" style="height:50px" alt="">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td> @php */ @endphp
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                            <td>
                                                @if($product->duration)
                                                    @php
                                                        $entryDate = \Carbon\Carbon::parse($product->created_at);
                                                        $expiryDate = $entryDate->copy()->addDays($product->duration);
                                                        $now = \Carbon\Carbon::now();
                                                        $daysLeft = $now->diffInDays($expiryDate, false);
                                                    @endphp
                                                    @if($daysLeft >= 0)
                                                        {{ $daysLeft }} days left
                                                    @else
                                                        Expired
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a title="View" href="{{ route('admin.products.show', $product->id) }}"
                                                   class="btn btn-sm btn-secondary"> <i class="fas fa-eye"></i> </a>
                                                <a title="Edit" href="{{ route('admin.products.edit', $product->id) }}"
                                                   class="btn btn-sm btn-success"> <i class="fas fa-edit"></i> </a>
                                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No products found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
<script>
    $(document).on('change', '.approval-toggle', function () {
        let approved = this.checked ? 1 : 0;
        let id = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: '{{ route('admin.products.approval') }}',
            data: {
                id: id,
                approved: approved,
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                toastr.success('Approval status updated');
            },
            error: function () {
                toastr.error('Error updating status');
            }
        });
    });
</script>
@endsection
