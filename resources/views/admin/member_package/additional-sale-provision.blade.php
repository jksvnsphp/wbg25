@extends('admin.main-dashboard-frame')
@section('admin-content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card rounded-0">
                    <div class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                        All listed normal Products

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
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Date</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Used Balance</th>
                        <th>From</th>
                        <th>New Wallet Balance</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="dataBody">

                    @forelse($wallets as $wallet)
                        @php 
                            $vendor = $wallet->vendor;
                            $company = $vendor?->company;
                            $entryDate = \Carbon\Carbon::parse($wallet->created_at)->format('Y-m-d');
                        @endphp

                        <tr>
                            <td>{{ $entryDate }}</td>
                            <td>{{ $company?->name ?? 'N/A' }}</td>
                            <td>{{ $vendor?->email ?? 'N/A' }}</td>
                            <td>{{ $wallet->debit ?? '0' }}</td>
                            <td>
                              @php 
                                 if($wallet->type==='sale_provision'){
                                    $ItemId =getProductId($wallet->order_item_id);
                                 }
                              @endphp    
                            {{ (getNewWalletBalance($wallet->user_id,$wallet->id)-$wallet->debit ?? '0') + $wallet->debit ?? '0' }}</td>
                            <td>{{ getNewWalletBalance($wallet->user_id,$wallet->id)-$wallet->debit ?? '0' }}</td>

                            <td>
                                

                                
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger">No records found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
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
        function toggleAddCategory() {
            $('#category_card').toggleClass('d-none');
        }
    </script> --}}

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var status = this.checked ? 1 : 0;
                var id = $(this).attr('id').replace('checkbox', '');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.product.approval') }}',
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
