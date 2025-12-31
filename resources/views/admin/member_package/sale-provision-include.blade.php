@extends('admin.main-dashboard-frame')
@section('admin-content')

<div class="container-fluid">

    {{-- Page Title --}}
  
     

    {{-- Filter Box (Grey Header Area Like Screenshot) --}}
    <div class="card shadow-sm rounded-0 mb-3">
         
        <div
                        class="card-header d-flex justify-content-between align-items-center rounded-0 py-2 bg-dark text-light font-weight-bolder">
                       Include Sale Provision
                    </div>

        <!-- <div class="card-body pb-1">

            {{-- 🔎 Search Field: By Company + By Date --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" id="searchInput"
                        class="form-control"
                        placeholder="Search: By Company + By Date">
                </div>
            </div>

            {{-- Show Entries (10 - 50 - 100 - 200) --}}
            <div class="mb-2">
                <span class="text-muted">Show </span>
                <a href="?pageItem=10" class="mx-1">10</a> -
                <a href="?pageItem=50" class="mx-1 text-danger">50</a> -
                <a href="?pageItem=100" class="mx-1 text-danger">100</a> -
                <a href="?pageItem=200" class="mx-1 text-danger">200</a>
                <span class="text-muted"> entries</span>
            </div>

        </div> -->
    </div>

    {{-- TABLE --}}
    <div class="card rounded-0 shadow-sm">
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

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-2">
            {{ $wallets->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection
