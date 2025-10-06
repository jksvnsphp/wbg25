@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        All SellOut Products

                    </div>

                    <div class="card-body pb-0">

                        <style>
                            td {
                                padding: 2px 7px !important;
                            }

                            .product_img {
                                height: 4rem !important;
                                width: 4rem !important;
                            }

                            .nowrap {
                                white-space: nowrap !important;

                            }
                        </style>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Image</th>
                                        <th class="nowrap">Product Details</th>
                                        <th>Approved</th>
                                        <th>Wholesale</th>
                                        <th>Bulk</th>
                                        <th>Daily</th>
                                        <th>Hot</th>
                                        <th>Limit Offer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                        @forelse($products as $index => $product)
                                        <tr>
                                            <td>
                                               
                                            {{ $products->firstItem() + $index }}</td>
                                           <td>
                           @php
                         //  echo "<pre/>";
                           // print_r($product);die;

                           $gallery= $product->gallery->toArray();  
                           @endphp
                        @if($gallery && isset($gallery['0']['image']))
                            <img src="{{ asset('uploads/products/gallery/' . $gallery[0]['image']) }}" style="height:50px" alt="">
                        @else
                            <span>No Image</span>
                        @endif
                                            </td> 

                                            <td>
                                                @php
                                                        $entryDate = \Carbon\Carbon::parse($product->created_at);
                                                        $expiryDate = $entryDate->copy()->addDays($product->duration);
                                                        $now = \Carbon\Carbon::now();
                                                        $daysLeft = $now->diffInDays($expiryDate, false);
                                                    @endphp
                                               <!-- <p class="text-primary pb-0 mb-0 font-weight-bolder fs-3 text-capitalize" title="MacBook Pro"><a href="#" target="_blank">MacBook Pro</a></p> -->
                                            <div class="text-capitalize fs-2 font-weight-bold">{{ $product->name }}</div>
                                            <div class="text-muted">
                                                <span class="badge badge-success" style="font-size:13px;">Price: {{ $product->price }}</span>
                                                <span class="badge badge-warning" style="font-size:13px;">Qty: >{{ $product->totalQty ?? 'N/A' }}</span>
                                            </div>
                                            <small class="text-muted fs-1 nowrap">Entry Date: {{$expiryDate}}</small>    
                                            </td>
                                           
                                            <td>  @if($product->isList) <a href="" class="btn btn-sm btn-success"> <i class="fa fa-check" aria-hidden="true"></i> </a> @endif</td>
                                         
                                            <td>  <label class="switch round_switch">
                                                <input type="checkbox" id="proId" name="wholesale_pro" value="N" checked>
                                                <div class="slider round"></div>
                                            </label></td>
                                            <td>
                                                 <label class="switch round_switch">
                                                <input type="checkbox" id="bulkId" name="bulk" value="N">
                                                <div class="slider round"></div>
                                            </label>
                                            </td>

                                            <td>
                                                 <label class="switch round_switch">
                                                <input type="checkbox" id="bulkId" name="bulk" value="N">
                                                <div class="slider round"></div>
                                            </label>
                                            </td>

                                            <td>
                                                 <label class="switch round_switch">
                                                <input type="checkbox" id="bulkId" name="bulk" value="N">
                                                <div class="slider round"></div>
                                            </label>
                                            </td>

                                            <td>
                                                 <label class="switch round_switch">
                                                <input type="checkbox" id="bulkId" name="bulk" value="N">
                                                <div class="slider round"></div>
                                            </label>
                                            </td>
                                            <td>
                                                
                                                <!-- <a title="View" href="{{ route('admin.products.show', $product->id) }}"
                                                   class="btn btn-sm btn-secondary"> <i class="fas fa-eye"></i> </a>
                                                <a title="Edit" href="{{ route('admin.products.edit', $product->id) }}"
                                                   class="btn btn-sm btn-success"> <i class="fas fa-edit"></i> </a> -->
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
                                    <!-- <tr>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">
                                            <div>
                                                <img src="{{asset('dashboard/img/tender-category/1.jpg')}}" class="product_img img-thumbnail" alt="">
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-primary pb-0 mb-0 font-weight-bolder fs-3 text-capitalize" title="MacBook Pro"><a href="#" target="_blank">MacBook Pro</a></p>
                                            <div class="text-capitalize fs-2 font-weight-bold">Samsung</div>
                                            <div class="text-muted">
                                                <span class="badge badge-success" style="font-size:13px;">Price: 1299.00</span>
                                                <span class="badge badge-warning" style="font-size:13px;">Qty: 0</span>
                                            </div>
                                            <small class="text-muted fs-1 nowrap">Entry Date: 2023-07-27</small>
                                        </td>
                                        <td class="align-middle">
                                            <a href="" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        </td>
                                        <td class="align-middle">
                                            <label class="switch round_switch">
                                                <input type="checkbox" id="proId" name="wholesale_pro" value="N" checked>
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td class="align-middle">
                                            <label class="switch round_switch">
                                                <input type="checkbox" id="bulkId" name="bulk" value="N">
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td class="align-middle">
                                            <label class="switch round_switch">
                                                <input type="checkbox" id="dailyId" name="daily" value="N">
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td class="align-middle">
                                            <label class="switch round_switch">
                                                <input type="checkbox" id="hotId" name="hot" value="N" checked>
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td class="align-middle">
                                            <label class="switch round_switch">
                                                <input type="checkbox" id="limitId" name="limit" value="N">
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td>
                                            <label title="Active/Inactive" class="switch round_switch">
                                                <input type="checkbox" id="id2" value="1">
                                                <div class="slider round"></div>
                                            </label>
                                            <a title="Edit" href="" class="btn m-1 btn-sm btn-success"> <i class="fas fa-edit    "></i> </a>
                                            <a title="Delete" href="" class="btn m-1 btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> </a>

                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>

    

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
@endsection
@section('custom-js')
    
    {{-- <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.update.status.user') }}',
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
    </script> --}}
@endsection
