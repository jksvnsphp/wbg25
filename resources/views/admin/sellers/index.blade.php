@extends('admin.main-dashboard-frame')
@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card rounded-0">
                <div class="card-header rounded-0 py-2 bg-dark text-light font-weight-bolder">
                    Show Sellers
                </div>
                <div class="card-body pb-0">
              @php /* @endphp
                    {{-- Search + Filter --}}
                    <form method="GET" action="">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="form-control" placeholder="Search by name, email, company...">
                            </div>
                           
                            <div class="col-md-2">
                                <select name="country" class="form-control">
                                    <option value="">All Countries</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}" {{ request('country') == $country->name ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                          
                            <div class="col-md-4">
                                <select name="sort" class="form-control">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                </select>
                            </div>
                           
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-secondary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
               @php */ @endphp
                    {{-- Table --}}
                    <div class="table-responsive">
                       <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>Join Date</th>
                                    <th>Member Type</th>
                                    <th>Login Details</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sellers as $index => $seller)
                                    <tr>
                                        <td>{{ $sellers->firstItem() + $index }}</td>
                                        <td>{{ $seller->company->name ?? '-' }}</td>
                                        <td>{{ $seller->email }}</td>
                                        <td>
                                            @if($seller->countryData)
                                                <img src="https://flagcdn.com/24x18/{{ strtolower($seller->countryData->iso2) }}.png" alt="">
                                                {{ $seller->countryData->name }}
                                            @endif
                                        </td>
                                        <td>{{ $seller->created_at->format('d M Y') }}</td>
                                        <td>
                                         @php  
                                       
                                         if(isset($seller->sellerPackage[0]->package_id)){
                                           
                                         
                                         @endphp
                                           {{getMemberPackageName($seller->sellerPackage[0]->package_id)?? 'Free' }}
                                        @php } else { echo "Free"; } @endphp

                                    </td>
                                    <td>
                                            <strong>Username:</strong> {{ $seller->email }}<br>
                                            <strong>Password:</strong> (hidden)             
                                        </td>
                                        <td>
                                            <label class="switch round_switch">
                                                <input type="checkbox" data-id="{{ $seller->id }}" class="status-toggle" 
                                                       {{ $seller->status ? 'checked' : '' }}>
                                                <div class="slider round"></div>
                                            </label>
                                        </td>
                                        <td>
                                            <a title="View" href="{{ route('admin.sellers.show', $seller->id) }}" class="btn m-1 btn-sm btn-secondary"><i class="fas fa-eye"></i></a>
                                            <a title="Edit" href="{{ route('admin.sellers.edit', $seller->id) }}" class="btn m-1 btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                            <form method="POST" action="{{ route('admin.sellers.destroy', $seller->id) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Delete" class="btn m-1 btn-sm btn-danger" onclick="return confirm('Delete this seller?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center">No sellers found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {{ $sellers->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
$(document).on('change', '.status-toggle', function() {
    let status = this.checked ? 1 : 0;
    let id = $(this).data('id');

    $.ajax({
        type: 'POST',
        url: '{{ route('admin.update.status.user') }}',
        data: {
            id: id,
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function() {
            toastr.success('Status updated successfully');
        },
        error: function() {
            toastr.error('Error updating status');
        }
    });
});
</script>
@endsection
